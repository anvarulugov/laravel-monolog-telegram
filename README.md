# Real-Time Laravel exception logs in your Telegram 🚀

## ❓ Why Another Logger?

Logging should be more than just saving data — it should **drive action**. Here’s why 🔔 **Telegram Handler for Monolog** 📝 is a game-changer:

- 🚀 **Real-Time Feedback** – Instantly receive logs in your Telegram chat.
- 🧠 **Actionable Insights** – Include useful context for quick understanding.
- 🛡️ **No Need for Sentry or Third-Party Services**
- ⚡ **Immediate Alerts** – Be notified of issues the moment they happen.
- 👥 **Team Collaboration** – Share logs in group chats for quick follow-up.
- 🧩 **Easy Customization** – Use PHP attributes to control log routing.

## ScreenShot

![image](https://user-images.githubusercontent.com/3877538/172431112-020d7a7c-f515-49bc-961a-3f63c9ff21af.png)

## 🎯 Installation

Install via Composer:

```sh
composer require anvarulugov/laravel-monolog-telegram
```

## ⚙️ Usage

Update your `config/logging.php` file to configure the Telegram logging channel.

### ⏳ Running Logs in a Queue

If a queue name is set, logs will be processed asynchronously in the specified queue. Otherwise, they will run synchronously.

### 🔧 Configuration Example

Modify your `config/logging.php` file:

```php
use Ulugov\MonologTelegram\Attributes\EmergencyAttribute;
use Ulugov\MonologTelegram\Attributes\CriticalAttribute;
use Ulugov\MonologTelegram\Attributes\ImportantAttribute;
use Ulugov\MonologTelegram\Attributes\DebugAttribute;
use Ulugov\MonologTelegram\Attributes\InformationAttribute;
use Ulugov\MonologTelegram\Attributes\LowPriorityAttribute;

return [
    'channels' => [
        'stack' => [
            'driver'   => 'stack',
            'channels' => ['single', 'telegram'],
        ],

        'telegram' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => TheCoder\MonologTelegram\TelegramBotHandler::class,
            'handler_with' => [
                'token' => env('LOG_TELEGRAM_BOT_TOKEN'),
                'chat_id' => env('LOG_TELEGRAM_CHAT_ID'),
                'topic_id' => env('LOG_TELEGRAM_TOPIC_ID', null),
                'bot_api' => env('LOG_TELEGRAM_BOT_API', 'https://api.telegram.org/bot'),
                'proxy' => env('LOG_TELEGRAM_BOT_PROXY', null),
                'queue' => env('LOG_TELEGRAM_QUEUE', null),
                'topics_level' => [
                    EmergencyAttribute::class => env('LOG_TELEGRAM_EMERGENCY_ATTRIBUTE_TOPIC_ID', null),
                    CriticalAttribute::class => env('LOG_TELEGRAM_CRITICAL_ATTRIBUTE_TOPIC_ID', null),
                    ImportantAttribute::class => env('LOG_TELEGRAM_IMPORTANT_ATTRIBUTE_TOPIC_ID', null),
                    DebugAttribute::class => env('LOG_TELEGRAM_DEBUG_ATTRIBUTE_TOPIC_ID', null),
                    InformationAttribute::class => env('LOG_TELEGRAM_INFORMATION_ATTRIBUTE_TOPIC_ID', null),
                    LowPriorityAttribute::class => env('LOG_TELEGRAM_LOWPRIORITY_ATTRIBUTE_TOPIC_ID', null),
                ]
            ],
            'formatter' => TheCoder\MonologTelegram\TelegramFormatter::class,
            'formatter_with' => [
                'tags' => env('LOG_TELEGRAM_TAGS', null),
            ],
        ],
    ],
];
```

### 🏷️ Topic-Based Logging

You can assign a **PHP Attribute (Annotation)** to controller methods, command handlers, or job handlers, enabling topic-based logging. The package will use the first detected attribute to determine the topic for logging messages.

#### 💡 Example:

**📌 Controller Method:**

```php
namespace App\Http\Controllers\NewWeb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ulugov\MonologTelegram\Attributes\EmergencyAttribute;

class HomeController extends Controller
{
    #[EmergencyAttribute]
    public function index(Request $request)
    {
        // Your logic here
    }
}
```

**⚡ Command or Job Handler:**

```php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Foundation\Bus\Dispatchable;
use Ulugov\MonologTelegram\Attributes\CriticalAttribute;

class ProcessData implements ShouldBeQueued
{
    use Dispatchable, Queueable;

    #[CriticalAttribute]
    public function handle()
    {
        // Job processing logic
    }
}
```

### 🔄 Customizing Log Settings at Runtime

You can dynamically set the bot token, chat ID, and topic ID while logging:

```php
logger('message', [
    'token' => 'your_bot_token',
    'chat_id' => 'your_chat_id',
    'topic_id' => 'your_topic_id'
]);
```

## 📜 Environment Variables

Ensure the following variables are set in your `.env` file:

```ini
LOG_TELEGRAM_BOT_TOKEN=
LOG_TELEGRAM_CHAT_ID=

# 🏷️ If using chat groups with topic support, define the topic ID
LOG_TELEGRAM_TOPIC_ID=

# 🌍 Optional: Change the API endpoint (default is Telegram's official API)
LOG_TELEGRAM_BOT_API='https://api.telegram.org/bot'

# 🛡️ Optional: Use a proxy (e.g., Tor for restricted regions)
LOG_TELEGRAM_BOT_PROXY='socks5h://localhost:9050'

# 🔥 Topic Level Configurations
LOG_TELEGRAM_EMERGENCY_ATTRIBUTE_TOPIC_ID=
LOG_TELEGRAM_CRITICAL_ATTRIBUTE_TOPIC_ID=
LOG_TELEGRAM_IMPORTANT_ATTRIBUTE_TOPIC_ID=
LOG_TELEGRAM_DEBUG_ATTRIBUTE_TOPIC_ID=
LOG_TELEGRAM_INFORMATION_ATTRIBUTE_TOPIC_ID=
LOG_TELEGRAM_LOWPRIORITY_ATTRIBUTE_TOPIC_ID=
```

## 📄 License

This package is open-source and available under the MIT License. 🏆

