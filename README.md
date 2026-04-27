# ncod3v/ai-sdk

**PHP SDK für die n0cl0n3.AI KI-Dienste** — v1.2.0

[![Packagist Version](https://img.shields.io/packagist/v/ncod3v/ai-sdk)](https://packagist.org/packages/ncod3v/ai-sdk)
[![PHP Version](https://img.shields.io/packagist/php-v/ncod3v/ai-sdk)](https://packagist.org/packages/ncod3v/ai-sdk)
[![License](https://img.shields.io/packagist/l/ncod3v/ai-sdk)](LICENSE)

13 KI-Dienste: Code-Analyse, SQL, Übersetzung, DSGVO, Meeting, **Social Media Generator**, **Startup Kalkulator** und mehr.

## Installation

```bash
composer require ncod3v/ai-sdk
```

## Quickstart

```php
use Ncod3v\AI\Client;

$ai = new Client('ncod3v_ihr_api_key');

// Code analysieren
$result = $ai->analyzeCode('<?php echo $_GET["id"]; ?>', 'php');
echo $result['quality_score']; // 0–100

// Social Media für mehrere Plattformen
$content = $ai->generateSocialContent(
    topic:     'Unser KI-Tool spart 80% Entwicklungszeit',
    platforms: ['instagram', 'linkedin', 'twitter'],
    tone:      'professional',
    industry:  'Tech'
);
echo $content['instagram']['post'];
echo implode(' ', $content['instagram']['hashtags']);

// Startup-Idee analysieren
$analysis = $ai->analyzeStartup(
    idea:          'KI-Buchhaltung für Freelancer',
    industry:      'FinTech',
    capital:       25000,
    businessModel: 'saas'
);
echo $analysis['success_probability']['overall'] . '%'; // z.B. 73%
echo $analysis['financial_projection']['break_even_months'] . ' Monate Break-Even';
```

## Alle Methoden

| Methode | Dienst | Plan |
|---|---|---|
| `analyzeCode($code, $language)` | Code-Analyse | Starter+ |
| `generateText($prompt, $type, $tone)` | Neuro-Text | Starter+ |
| `chat($messages, $persona)` | Quantum-Chat | Pro+ |
| `analyzeDocument($document, $task)` | Doc-Scanner | Pro+ |
| `generateSQL($description, $dialect)` | SQL-Generator | Starter+ |
| `optimizeCV($cv, $job, $mode)` | CV-Optimierer | Starter+ |
| `checkPrivacy($text, $docType)` | DSGVO-Checker | Pro+ |
| `generateMeetingProtocol($notes)` | Meeting-Protokoll | Pro+ |
| `triageEmail($email, $context)` | E-Mail-Triage | Pro+ |
| `analyzeSEO($content, $keyword)` | SEO-Analyse | Pro+ |
| `translate($text, $targetLang)` | Übersetzung | Starter+ |
| `generateSocialContent($topic, $platforms, $tone)` | **Social Media** ✨ | Pro+ |
| `analyzeStartup($idea, $industry, $capital)` | **Startup Kalkulator** ✨ | Pro+ |

## Social Media Generator

```php
$content = $ai->generateSocialContent(
    topic:     'Launch unserer neuen App',
    platforms: ['instagram', 'linkedin', 'twitter', 'tiktok'],
    tone:      'viral',  // professional|casual|viral|educational|motivational
    industry:  'Tech',
    keywords:  ['KI', 'App', 'Launch'],
    cta:       'Jetzt kostenlos testen',
    language:  'Deutsch'
);

// Jede Plattform bekommt spezifischen Content:
echo $content['instagram']['post'];
echo $content['linkedin']['post'];
echo $content['twitter']['tweet'];
echo $content['tiktok']['script'];
echo $content['tiktok']['hook'];
```

## Startup Kalkulator

```php
$analysis = $ai->analyzeStartup(
    idea:          'Automatisierte Social-Media-Planung für KMU',
    industry:      'SaaS',
    targetGroup:   'KMU',
    location:      'Deutschland',
    capital:       50000,
    founders:      2,
    experience:    'hoch',  // gering|mittel|hoch|experte
    businessModel: 'saas'
);

echo $analysis['success_probability']['overall'] . '%';
echo $analysis['financial_projection']['startup_costs']['einmalig'];
echo $analysis['financial_projection']['break_even_months'];
echo $analysis['verdict'];  // EMPFOHLEN|BEDINGT_EMPFOHLEN|NICHT_EMPFOHLEN

foreach ($analysis['risks'] as $risk) {
    echo "{$risk['risk']} → {$risk['mitigation']}\n";
}
```

## Fehlerbehandlung

```php
use Ncod3v\AI\Exception\AuthException;
use Ncod3v\AI\Exception\RateLimitException;
use Ncod3v\AI\Exception\ApiException;

try {
    $result = $ai->generateSocialContent('Mein Thema', ['instagram']);
} catch (AuthException $e)    { /* Ungültiger Key */ }
  catch (RateLimitException $e) { /* Limit erreicht */ }
  catch (ApiException $e)     { /* Sonstiger Fehler */ }
```

## Changelog

### v1.1.0 (2026-04-28)
- ✨ `generateSocialContent()` — 7 Plattformen optimiert
- ✨ `analyzeStartup()` — Erfolgswahrscheinlichkeit + Finanzplanung

### v1.0.0 (2026-04-27)
- 🎉 Initial Release, 11 Dienste

## Links

- **Docs:** https://ai.noclone.de/dokumentation.php
- **Portal:** https://ai.noclone.de/portal/
- **Packagist:** https://packagist.org/packages/ncod3v/ai-sdk

## Lizenz

MIT
