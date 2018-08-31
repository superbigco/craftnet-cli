<?php

namespace CraftnetCli\Command\CraftnetCli;

use CraftnetCli\Credentials;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class SetCredentialsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('licenses:credentials')
            ->setDescription('Set credentials')
            ->setHelp('Easily set your Craft ID credentials');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $credentials = new Credentials();
        $output->writeln([
            'Enter your Craft ID credentials. You may generate a API key on https://id.craftcms.com/developer/settings',
            '==============================================',
        ]);

        $helper   = $this->getHelper('question');
        $question = new Question('What is your Craft ID username? ');
        $username = $helper->ask($input, $output, $question);

        if (!$username) {
            return;
        }

        $question = new Question('And your API key? ');
        $apiKey   = $helper->ask($input, $output, $question);

        if (!$apiKey) {
            return;
        }

        $success = $credentials
            ->setUsername(trim($username))
            ->setApiKey(trim($apiKey))
            ->writeCredentials();

        $output->writeln([
            'The following has been set:',
            '',
            "Username: {$username}",
            "API key: {$apiKey}",
            '',
        ]);
    }
}