<?php

declare(strict_types=1);

namespace Ncod3v\AI;

use Ncod3v\AI\Exception\ApiException;
use Ncod3v\AI\Exception\RateLimitException;
use Ncod3v\AI\Exception\AuthException;

/**
 * n0cl0n3.AI PHP SDK — Client
 *
 * Einfacher Zugang zu allen KI-Diensten der n0cl0n3.AI API.
 *
 * @package  ncod3v/ai-sdk
 * @version  1.0.0
 * @author   Holger Mauch <kontakt@noclone.de>
 * @license  MIT
 * @link     https://ai.noclone.de/dokumentation.php
 */
class Client
{
    public const VERSION       = '1.0.0';
    public const BASE_URL      = 'https://ai.noclone.de/api';
    public const DEFAULT_MODEL = 'claude-sonnet-4-5-20251022';

    private string $apiKey;
    private int    $timeout;
    private bool   $verify;
    private array  $lastMeta = [];

    /**
     * @param string $apiKey  Ihr API-Key (ncod3v_...)
     * @param int    $timeout Request-Timeout in Sekunden
     * @param bool   $verify  SSL-Zertifikat prüfen
     */
    public function __construct(
        string $apiKey,
        int    $timeout = 60,
        bool   $verify  = true
    ) {
        if (empty($apiKey)) {
            throw new AuthException('API-Key darf nicht leer sein.');
        }

        $this->apiKey  = $apiKey;
        $this->timeout = $timeout;
        $this->verify  = $verify;
    }

    // =========================================================
    // ── Dienste ──────────────────────────────────────────────
    // =========================================================

    /**
     * Code-Analyse: Sicherheit, Qualität, Bugs, Best Practices.
     *
     * @param  string  $code      Quellcode zur Analyse
     * @param  string  $language  Programmiersprache (auto|php|python|java|js|...)
     * @return array{
     *   quality_score: int,
     *   summary: string,
     *   bugs: array,
     *   security: array,
     *   improvements: array,
     *   tokens_in: int,
     *   tokens_out: int,
     *   duration_ms: int
     * }
     */
    public function analyzeCode(string $code, string $language = 'auto'): array
    {
        return $this->post('analyze.php', compact('code', 'language'));
    }

    /**
     * Neuro-Text: KI-Texterstellung für Blog, Marketing, E-Mail, Readme usw.
     *
     * @param  string  $prompt    Beschreibung / Thema
     * @param  string  $type      blog|marketing|email|readme|summary|general
     * @param  string  $tone      professional|casual|technical|persuasive|formal
     * @param  string  $language  Zielsprache (Deutsch|Englisch|...)
     */
    public function generateText(
        string $prompt,
        string $type     = 'general',
        string $tone     = 'professional',
        string $language = 'Deutsch'
    ): array {
        return $this->post('generate.php', compact('prompt', 'type', 'tone', 'language'));
    }

    /**
     * Quantum-Chat: Multi-Turn-Konversation mit KI-Persona.
     *
     * @param  array   $messages    [['role'=>'user','content'=>'...'], ...]
     * @param  string  $persona     KI-Persona-Name
     * @param  string  $systemExtra Zusätzlicher System-Prompt
     */
    public function chat(
        array  $messages,
        string $persona     = 'n0cl0n3.AI',
        string $systemExtra = ''
    ): array {
        return $this->post('chat.php', compact('messages', 'persona', 'systemExtra'));
    }

    /**
     * Doc-Scanner: Dokumentenanalyse, Zusammenfassung, Extraktion.
     *
     * @param  string  $document  Dokumenttext
     * @param  string  $task      summary|extract|analyze|translate|classify
     */
    public function analyzeDocument(string $document, string $task = 'summary'): array
    {
        return $this->post('analyze.php', ['document' => $document, 'task' => $task]);
    }

    /**
     * SQL-Generator: SQL aus natürlicher Sprache erzeugen oder optimieren.
     *
     * @param  string  $description  Was soll die Query tun?
     * @param  string  $dialect      MySQL|PostgreSQL|SQLite|MSSQL|Oracle
     * @param  string  $schema       Optional: DDL-Schema der Tabellen
     * @param  string  $mode         generate|optimize|explain|fix
     */
    public function generateSQL(
        string $description,
        string $dialect = 'MySQL',
        string $schema  = '',
        string $mode    = 'generate'
    ): array {
        return $this->post('sql.php', compact('description', 'dialect', 'schema', 'mode'));
    }

    /**
     * CV-Optimierer: Lebenslauf auf Stellenanzeige optimieren.
     *
     * @param  string  $cv              Lebenslauf-Text
     * @param  string  $jobDescription  Stellenanzeige
     * @param  string  $mode            optimize|analyze|cover_letter
     */
    public function optimizeCV(
        string $cv,
        string $jobDescription,
        string $mode = 'optimize'
    ): array {
        return $this->post('cv.php', ['cv' => $cv, 'job' => $jobDescription, 'mode' => $mode]);
    }

    /**
     * DSGVO-Checker: Datenschutzkonformität von Texten prüfen.
     *
     * @param  string  $text     Zu prüfender Text (AGB, Datenschutzerklärung, ...)
     * @param  string  $docType  agb|datenschutz|impressum|vertrag|email
     */
    public function checkPrivacy(string $text, string $docType = 'agb'): array
    {
        return $this->post('datenschutz.php', ['text' => $text, 'doc_type' => $docType]);
    }

    /**
     * Meeting-Protokoll: Notizen in strukturiertes Protokoll umwandeln.
     *
     * @param  string  $notes         Meeting-Notizen / Transkript
     * @param  string  $meetingTitle  Titel des Meetings
     * @param  string  $date          Datum (Y-m-d)
     * @param  array   $participants  Teilnehmerliste
     */
    public function generateMeetingProtocol(
        string $notes,
        string $meetingTitle = '',
        string $date         = '',
        array  $participants = []
    ): array {
        return $this->post('meeting.php', compact('notes', 'meetingTitle', 'date', 'participants'));
    }

    /**
     * E-Mail-Triage: E-Mails kategorisieren, priorisieren und beantworten.
     *
     * @param  string  $email    E-Mail-Inhalt
     * @param  string  $context  Optionaler Kontext (z.B. Ihre Rolle)
     */
    public function triageEmail(string $email, string $context = ''): array
    {
        return $this->post('email-triage.php', ['email' => $email, 'context' => $context]);
    }

    /**
     * SEO-Analyse: Inhalt auf SEO-Qualität prüfen und verbessern.
     *
     * @param  string  $content        Text / HTML-Inhalt
     * @param  string  $targetKeyword  Haupt-Keyword
     * @param  string  $url            Seiten-URL (optional)
     */
    public function analyzeSEO(
        string $content,
        string $targetKeyword = '',
        string $url           = ''
    ): array {
        return $this->post('seo.php', compact('content', 'targetKeyword', 'url'));
    }

    /**
     * Übersetzung: Text in 50+ Sprachen übersetzen mit Fachvokabular.
     *
     * @param  string  $text       Zu übersetzender Text
     * @param  string  $targetLang Zielsprache (Englisch|Französisch|...)
     * @param  string  $sourceLang Quellsprache (auto|Deutsch|...)
     * @param  string  $domain     general|legal|medical|technical|marketing
     */
    public function translate(
        string $text,
        string $targetLang,
        string $sourceLang = 'auto',
        string $domain     = 'general'
    ): array {
        return $this->post('translate.php', compact('text', 'targetLang', 'sourceLang', 'domain'));
    }

    // =========================================================
    // ── Meta ─────────────────────────────────────────────────
    // =========================================================

    /**
     * Metadaten des letzten API-Calls (Tokens, Latenz).
     */
    public function getLastMeta(): array
    {
        return $this->lastMeta;
    }

    // =========================================================
    // ── HTTP-Kern ─────────────────────────────────────────────
    // =========================================================

    private function post(string $endpoint, array $body): array
    {
        $url = rtrim(self::BASE_URL, '/') . '/' . ltrim($endpoint, '/');

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'X-API-Key: ' . $this->apiKey,
                'X-Requested-With: XMLHttpRequest',
                'User-Agent: ncod3v-ai-sdk/' . self::VERSION . ' PHP/' . PHP_VERSION,
            ],
            CURLOPT_POSTFIELDS     => json_encode($body),
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_SSL_VERIFYPEER => $this->verify,
            CURLOPT_SSL_VERIFYHOST => $this->verify ? 2 : 0,
        ]);

        $raw  = curl_exec($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($raw === false) {
            throw new ApiException('cURL-Fehler: ' . $err);
        }

        $data = json_decode($raw, true);

        if ($http === 401) throw new AuthException($data['error'] ?? 'Ungültiger API-Key');
        if ($http === 429) throw new RateLimitException($data['error'] ?? 'Rate-Limit erreicht');
        if ($http !== 200) throw new ApiException($data['error'] ?? "HTTP $http");

        if (!isset($data['result']) && !isset($data['parsed'])) {
            throw new ApiException('Unerwartetes Response-Format');
        }

        // Meta speichern
        $this->lastMeta = [
            'tokens_in'   => $data['tokens_in']   ?? 0,
            'tokens_out'  => $data['tokens_out']  ?? 0,
            'tokens_total'=> ($data['tokens_in'] ?? 0) + ($data['tokens_out'] ?? 0),
            'duration_ms' => $data['duration_ms'] ?? 0,
        ];

        // Parsed-Daten + Meta flach zurückgeben
        $result = $data['parsed'] ?? ['result' => $data['result'] ?? $data];
        return array_merge($result, $this->lastMeta);
    }
}
