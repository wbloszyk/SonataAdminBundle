<?php

namespace Sonata\AdminBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'sonata:admin:install-assets',
    description: 'Copy assets from SonataAdminBundle into assets/sonata_admin/ project directory.'
)]
class InstallSonataAssetsCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filesystem = new Filesystem();

        $sourceDir = __DIR__ . '/../../assets';
        $targetDir = 'assets/sonata_admin';

        try {
            if ($filesystem->exists($sourceDir)) {
                $filesystem->mirror($sourceDir, $targetDir, null, ['override' => true]);
                $io->success('Pliki źródłowe assetów Sonaty zostały pomyślnie skopiowane do ' . $targetDir);
            } else {
                $io->error('Nie znaleziono katalogu źródłowego w bundle\'u: ' . $sourceDir);
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $io->error('Wystąpił błąd podczas kopiowania plików: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
