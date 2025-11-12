<?php declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use JDecool\OllamaClient\ClientBuilder;
use JDecool\OllamaClient\Client\Message;
use JDecool\OllamaClient\Client\Tool;
use JDecool\OllamaClient\Client\ToolFunction;
use JDecool\OllamaClient\Client\Request\ChatRequest;

$builder = new ClientBuilder();
$client = $builder->create();

$request = new ChatRequest(
    model: 'llama3.1',
    messages: $messages = [
        new Message('user', 'What is the weather in San Francisco?'),
    ],
    tools: [
        new Tool(
            type: Tool::TYPE_FUNCTION,
            function: new ToolFunction(
                name: 'get_current_weather',
                description: 'Get the current weather for a location',
                parameters: [
                    'type' => 'object',
                    'properties' => [
                        'location' => [
                            'type' => 'string',
                            'description' => 'The city and state, e.g., San Francisco, CA',
                        ],
                        'unit' => [
                            'type' => 'string',
                            'enum' => ['celsius', 'fahrenheit'],
                            'description' => 'The unit of temperature',
                        ],
                    ],
                    'required' => ['location'],
                ],
            ),
        ),
    ],
);

$response = $client->chat($request);
var_dump($response);

// Check if the model wants to use a tool
if ($response->message->toolCalls !== null) {
    foreach ($response->message->toolCalls as $toolCall) {
        echo "Function: {$toolCall->function->name}\n";
        echo "Arguments: " . json_encode($toolCall->function->arguments, JSON_PRETTY_PRINT) . "\n";

        // Simulate executing the function
        $functionResult = match($toolCall->function->name) {
            'get_current_weather' => json_encode([
                'temperature' => 72,
                'unit' => $toolCall->function->arguments['unit'] ?? 'fahrenheit',
                'condition' => 'sunny',
            ]),
            default => json_encode(['error' => 'Unknown function']),
        };

        // Add assistant message with tool calls
        $messages[] = $response->message;

        // Add tool response message
        $messages[] = new Message(
            role: 'tool',
            content: (string) $functionResult,
        );
    }

    // Send the conversation back with tool results
    $finalRequest = new ChatRequest(
        model: 'llama3.1',
        messages: $messages,
    );

    var_dump($client->chat($finalRequest));
}
