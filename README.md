# genau.chat Widget for TYPO3

Adds the [genau.chat](https://genau.chat) AI chat widget to your TYPO3 website.
The widget turns website visitors into customers — easy setup in just a few clicks.

## Requirements

- TYPO3 13.4+
- PHP 8.2+

## Installation

```bash
composer require genauchat/typo3-plugin
```

Then flush TYPO3 caches.

## Setup

1. Go to **Admin Tools → genau.chat** in the TYPO3 backend
2. Sign up at [genau.chat](https://genau.chat) and add your website
3. Copy your widget code and paste it into the field
4. Click **Save** — the widget appears on all pages immediately

## Features

- Backend module for easy configuration
- Enable / disable widget with one click
- Widget code is injected before `</body>` on all frontend pages
- Validates that the script belongs to genau.chat

## License

GPL-2.0-or-later
