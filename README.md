# Mailchimp - Newsletter Subscription for TYPO3 CMS

Simple Mailchimp newsletter subscription form as a content element in TYPO3.

## Features

- Email subscription form with AJAX submission
- Mailchimp API v3 integration
- Multi-language support (EN, DE, CS included)
- Customizable templates and styling

## Requirements

- PHP 8.3+
- TYPO3 13.4 or 14.x
- Mailchimp account with API key

## Installation

Install via Composer:

```bash
composer require marekskopal/typo3-mailchimp
```

## Configuration

### Mailchimp API Credentials

You need a Mailchimp API key and Audience List ID:

1. Log in to your Mailchimp account
2. Go to **Account & Billing** → **Extras** → **API keys**
3. Create a new API key
4. Note the server prefix from your API key (e.g., `us1`, `us2`, `eu1`) - it's the part after the dash
5. Go to **Audience** → **Settings** → **Audience name and defaults** to find your Audience ID

### TypoScript Setup

Include the TypoScript Set "Mailchimp" in your site configuration, then configure the settings:

```typoscript
plugin.tx_msmailchimp.settings {
    apiKey = your-api-key-us1
    serverPrefix = us1
    listId = your-audience-list-id
}
```

### Available Settings

| Setting | Default | Description |
|---------|---------|-------------|
| `settings.apiKey` | - | Mailchimp API key (required) |
| `settings.listId` | - | Mailchimp Audience/List ID (required) |
| `view.templateRootPath` | EXT:ms_mailchimp/Resources/Private/Templates/ | Path to templates |
| `view.partialRootPath` | EXT:ms_mailchimp/Resources/Private/Partials/ | Path to partials |
| `view.layoutRootPath` | EXT:ms_mailchimp/Resources/Private/Layouts/ | Path to layouts |

## Usage

Add the "Mailchimp Subscription" content element to your page. Users can enter their email address and subscribe to your Mailchimp audience list.

## Customization

### Templates

Override templates by setting custom paths in TypoScript:

```typoscript
plugin.tx_msmailchimp.view.templateRootPath = EXT:your_extension/Resources/Private/Templates/MsMailchimp/
```

### Styling

The extension includes basic CSS. Override by including your own styles or modifying the CSS classes:

- `.msmailchimp` - Main container
- `.msmailchimp-form` - Form element
- `.msmailchimp-input` - Email input field
- `.msmailchimp-button` - Submit button
- `.msmailchimp-message` - Message container
- `.msmailchimp-message--success` - Success message
- `.msmailchimp-message--error` - Error message

### Translations

Included languages: English, German, Czech. Add your own by creating language files in `Resources/Private/Language/`.

## License

GPL-2.0-or-later
