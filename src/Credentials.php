<?php

namespace CraftnetCli;

use Dotenv\Exception\InvalidPathException;
use Symfony\Component\Console\Output\OutputInterface;

class Credentials
{
    const USERNAME = 'USERNAME';
    const APIKEY   = 'APIKEY';
    const FILENAME = '.craftnet';

    protected $dotenv;
    protected $output;
    private   $_username;
    private   $_apiKey;

    public function __construct(OutputInterface $output = null)
    {
        $this->output = $output;

        try {
            $this->dotenv = new \Dotenv\Dotenv($this->getHomePath(), static::FILENAME);
            $this->dotenv->load();

            $this->_username = getenv(static::USERNAME);
            $this->_apiKey   = getenv(static::APIKEY);
        } catch (InvalidPathException $e) {
            if ($this->output) {
                $this->output->writeln([
                    'Invalid credentials at ' . $this->getHomePath(),
                    'Please run licensenses:credentials',
                ]);
            }
        }
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function getApiKey()
    {
        return $this->_apiKey;
    }

    public function getAuthPair()
    {
        return [$this->getUsername(), $this->getApiKey()];
    }

    public function setUsername($username = '')
    {
        $this->_username = $username;

        return $this;
    }

    public function setApiKey($apiKey = '')
    {
        $this->_apiKey = $apiKey;

        return $this;
    }

    public function writeCredentials()
    {
        $path = $this->getHomePath() . DIRECTORY_SEPARATOR . static::FILENAME;

        if (!is_writable($this->getHomePath())) {
            throw new \InvalidArgumentException("Can't write to {$this->getHomePath()}");
        }

        $usernameField = static::USERNAME;
        $keyField      = static::APIKEY;
        $content       = "{$usernameField}={$this->getUsername()}\n";
        $content       .= "{$keyField}={$this->getApiKey()}\n";

        return file_put_contents($path, $content);
    }

    public function getHomePath()
    {
        $path = $_SERVER['HOME'];

        if (empty($path)) {
            throw new \InvalidArgumentException('Can\t detect user home directory');
        }

        return $path;
    }
}