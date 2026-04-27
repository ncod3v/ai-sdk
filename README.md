# ncod3v/ai-sdk

**PHP SDK für die n0cl0n3.AI KI-Dienste**

[![Packagist Version](https://img.shields.io/packagist/v/ncod3v/ai-sdk)](https://packagist.org/packages/ncod3v/ai-sdk)
[![PHP Version](https://img.shields.io/packagist/php-v/ncod3v/ai-sdk)](https://packagist.org/packages/ncod3v/ai-sdk)
[![License](https://img.shields.io/packagist/l/ncod3v/ai-sdk)](LICENSE)

Einfacher Zugang zu 10 KI-Diensten — Code-Analyse, SQL-Generator, Übersetzung, DSGVO-Checker, Meeting-Protokoll, E-Mail-Triage und mehr.

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
echo $result['quality_score'];  // 0–100
echo $result['summary'];

// SQL generieren
$sql = $ai->generateSQL('Alle Kunden aus Stuttgart sortiert nach Name', 'MySQL');
echo $sql['query'];

// Text übersetzen
$trans = $ai->translate('Guten Morgen', 'Englisch');
echo $trans['translation'];  // Good morning

// Token-Verbrauch
$meta = $ai->getLastMeta();
echo $meta['tokens_total'] . ' Tokens · ' . $meta['duration_ms'] . 'ms';
```

## Dienste & Methoden

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

## Beispiele

### Code-Analyse
```php
$result = $ai->analyzeCode($phpCode, 'php');

// Rückgabe
$result['quality_score']  // int 0–100
$result['summary']        // string Zusammenfassung
$result['bugs']           // array gefundene Bugs
$result['security']       // array Sicherheitsprobleme
$result['improvements']   // array Verbesserungsvorschläge
```

### SQL-Generator
```php
$result = $ai->generateSQL(
    description: 'Alle Bestellungen der letzten 30 Tage mit Kundennamen',
    dialect:     'MySQL',
    schema:      'orders(id,customer_id,total,created_at), customers(id,name,email)',
    mode:        'generate'  // generate|optimize|explain|fix
);

echo $result['query'];
echo $result['explanation'];
```

### Multi-Turn Chat
```php
$messages = [
    ['role' => 'user',      'content' => 'Was ist ein JOIN in SQL?'],
    ['role' => 'assistant', 'content' => 'Ein JOIN...'],
    ['role' => 'user',      'content' => 'Kannst du ein Beispiel zeigen?'],
];

$result = $ai->chat($messages, persona: 'SQL-Experte');
echo $result['result'];
```

### Fehlerbehandlung
```php
use Ncod3v\AI\Exception\AuthException;
use Ncod3v\AI\Exception\RateLimitException;
use Ncod3v\AI\Exception\ApiException;

try {
    $result = $ai->analyzeCode($code);
} catch (AuthException $e) {
    // Ungültiger API-Key
    echo 'Auth-Fehler: ' . $e->getMessage();
} catch (RateLimitException $e) {
    // Demo-Limit oder Plan-Limit erreicht
    echo 'Rate-Limit: ' . $e->getMessage();
} catch (ApiException $e) {
    // Sonstiger API-Fehler
    echo 'API-Fehler: ' . $e->getMessage();
}
```

## API-Key erhalten

API-Keys unter **[ai.noclone.de/portal](https://ai.noclone.de/portal/)** erstellen.

Demo ohne Key: 5 Anfragen/Dienst/Tag (kein Key nötig — einfach weglassen oder leer lassen).

## Links

- **API-Dokumentation:** https://ai.noclone.de/dokumentation.php
- **Preise & Pläne:** https://ai.noclone.de/preise.php
- **Support:** kontakt@noclone.de

## Lizenz

MIT — siehe [LICENSE](LICENSE).
