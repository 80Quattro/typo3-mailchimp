# Instafeed - Instagram Feed Plugin for TYPO3 CMS

Displays Instagram posts as a content element in TYPO3.

## Requirements
- TYPO3 13.4 or 14.x
- Instagram Graph API access token

## Installation

Install via Composer:

```bash
composer require marekskopal/typo3-instafeed
```

## Configuration

### Instagram API Token

You need a valid Instagram Graph API access token. To obtain one:

1. Create a Facebook Developer account at https://developers.facebook.com
2. Create a new app and add the Instagram Graph API product
3. Generate a long-lived access token

### TypoScript Setup

Include the TypoScript Set "Instafeed" in your site configuration, then configure the access token:

```typoscript
plugin.tx_msinstafeed.settings.accessToken = YOUR_ACCESS_TOKEN
```

### Available Settings

| Setting | Default | Description |
|---------|---------|-------------|
| `settings.accessToken` | - | Instagram Graph API access token (required) |
| `settings.list.limit` | 6 | Number of posts to display |
| `view.templateRootPath` | EXT:ms_instafeed/Resources/Private/Templates/ | Path to templates |
| `view.partialRootPath` | EXT:ms_instafeed/Resources/Private/Partials/ | Path to partials |
| `view.layoutRootPath` | EXT:ms_instafeed/Resources/Private/Layouts/ | Path to layouts |

## Usage

Add the "Instafeed" content element to your page. The plugin will fetch and cache Instagram posts for 24 hours.

## License

GPL-2.0-or-later