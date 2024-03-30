<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\Writer;

use RuntimeException;

class Template
{
    private string $code;

    private function __construct(
        string $code,
    ) {
        $this->code = str_replace("\r", "\n", str_replace("\r\n", "\n", $code));
        $this->fillPlaceholder('TOPCOMMENT', [
            '/*',
            ' * WARNING: DO NOT EDIT THIS FILE',
            ' * It has been generated automaticlly from a template.',
            ' * Edit the template instead.',
            ' */',
        ]);
    }

    public static function fromFile(string $path): self
    {
        $code = is_file($path) ? file_get_contents($path) : false;
        if ($code === false) {
            throw new RuntimeException("Failed to find the template file {$path}");
        }

        return new self($code);
    }

    public function fillPlaceholder(string $key, array $lines, bool $addNewLine = true): void
    {
        $placeholder = "/* <<{$key}>> */";
        $placeholderPosition = strpos($this->code, $placeholder);
        if ($placeholderPosition === false) {
            throw new RuntimeException("Failed to find the placeholder {$placeholder}");
        }
        if (strpos($this->code, $placeholder, $placeholderPosition + 1) !== false) {
            throw new RuntimeException("Placeholder {$placeholder} found more than once");
        }
        $closingPlaceholder = "/* <</{$key}>> */";
        $placeholderClosingPosition = strpos($this->code, $closingPlaceholder);
        if ($placeholderClosingPosition !== false) {
            if ($placeholderClosingPosition < $placeholderPosition) {
                throw new RuntimeException("Closing placeholder {$closingPlaceholder} found before {$placeholder}");
            }
            $this->code = substr($this->code, 0, $placeholderPosition + strlen($placeholder)) . substr($this->code, $placeholderClosingPosition + strlen($closingPlaceholder));
        }
        $indent = '';
        $stripBeforeFirst = 0;
        $onlySpaces = true;
        for ($index = $placeholderPosition - 1; $index >= 0; $index--) {
            if ($this->code[$index] === ' ') {
                $indent = $this->code[$index] . $indent;
                if ($onlySpaces) {
                    $stripBeforeFirst++;
                }
                continue;
            }
            if ($this->code[$index] === "\n") {
                break;
            }
            $onlySpaces = false;
            break;
        }
        $before = substr($this->code, 0, $placeholderPosition - $stripBeforeFirst);
        $after = substr($this->code, $placeholderPosition + strlen($placeholder));
        $middle = '';
        foreach ($lines as $line) {
            if ($line !== '') {
                $middle .= $indent . $line;
            }
            if ($addNewLine) {
                $middle .= "\n";
            }
        }
        if ($after !== '' && $after[0] === "\n") {
            $after = substr($after, 1);
        }
        $this->code = $before . $middle . $after;
    }

    public function save(string $filename)
    {
        $dirname = dirname($filename);
        if ($dirname && !is_dir($dirname) && !mkdir($dirname, 0777, true)) {
            throw new RuntimeException("Failed to create directory {$dirname}");
        }
        if (is_file($filename)) {
            throw new RuntimeException("File already exists: {$filename}");
        }
        if (file_put_contents($filename, $this->code) === false) {
            throw new RuntimeException("Failed to save file {$filename}");
        }
    }
}