<?php

namespace CraftnetCli\Command\CraftnetCli;

use CraftnetCli\Client;
use CraftnetCli\Credentials;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GetLicenseCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('licenses:get')
            ->setDescription('Get details about a license from Craftnet')
            ->addOption('key', null, InputOption::VALUE_REQUIRED, 'License Key');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $credentials = new Credentials($output);
        $input->validate();
        
        $client   = new Client();
        $response = $client->getLicense($input->getOption('key'));

        $body = json_decode($response->getBody(), true);

        $output->writeln(PrettyJson($body));

        return 0;
    }
}