# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Build & Quality Commands

```bash
# Install dependencies
composer install

# Static analysis (level max)
./vendor/bin/phpstan analyse

# Code style check (PSR-12 + Slevomat)
./vendor/bin/phpcs

# Auto-fix code style
./vendor/bin/phpcbf

# Run tests (no tests exist yet)
./vendor/bin/phpunit
```

## Architecture

This is a TYPO3 CMS extension (`ms_mailchimp`) that provides a simple Mailchimp newsletter subscription form.

**Namespace:** `MarekSkopal\MsMailchimp`

### Key Components

- **SubscriptionController** (`Classes/Controller/`) - Extbase controller with `formAction()` to display form and `subscribeAction()` for AJAX subscription
- **MailchimpClient** (`Classes/Client/`) - Handles Mailchimp API v3 communication for adding subscribers
- **SubscribeResponse** (`Classes/Dto/`) - Data transfer object for API response

### Data Flow

1. User views the form (`formAction`) rendered via Fluid template
2. JavaScript intercepts form submission and sends AJAX POST request
3. Controller validates email and calls `MailchimpClient::subscribe()`
4. Client sends request to Mailchimp API v3 (`/lists/{listId}/members`)
5. JSON response is returned to JavaScript for display

### Configuration

TypoScript Sets (TYPO3 13+) are in `Configuration/Sets/MsMailchimp/`. Required settings:

```typoscript
plugin.tx_msmailchimp.settings.apiKey = YOUR_MAILCHIMP_API_KEY
plugin.tx_msmailchimp.settings.serverPrefix = us1
plugin.tx_msmailchimp.settings.listId = YOUR_AUDIENCE_LIST_ID
```

## Requirements

- PHP 8.3+
- TYPO3 13.4+ or 14.1+
- Valid Mailchimp API key and Audience List ID

## Code Style

- Strict types enabled in all files
- Readonly classes/properties where applicable
- Constructor property promotion
- PHPStan level `max` with bleeding edge and strict rules
- PSR-12 with Slevomat Coding Standard