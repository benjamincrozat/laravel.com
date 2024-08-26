![](https://github.com/user-attachments/assets/15ccebbf-de3a-4812-88d0-9f93f722a675)

# Laravel Documentation With a Chatbot

An intelligent chatbot system based on GPT-4o mini for Laravel documentation that prioritizes accuracy and prevents hallucinations seemlessly integrated into Laravel's documentation.

## Key Features

- **Hallucination Prevention**: Ensures responses are based on direct input of relevant information.
- **Up-to-date Information**: Guarantees that the provided information is current.
- **Speed**: Delivers fast responses to user queries.
- **Seamless Integration**: Designed to work smoothly with your daily workflow.

## How It Works

The system prevents the language model from responding without access to relevant, verified information. This approach significantly reduces the risk of inaccurate or hallucinated responses. To make it convenient, you can insist for answers.

Everything happens in the Livewire component in `app/Livewire/Conversation.php`.

## Future Development

- Expanding the system to answer any question without requiring navigation to specific documentation pages.

## Demo

https://laravel.benjamincrozat.com

## Known Issues

- There's no pre-caching. Each page takes a bit of time to load.
- Clicking on an Algolia search result sends you to laravel.com instead of laravel.benjamincrozat.com
