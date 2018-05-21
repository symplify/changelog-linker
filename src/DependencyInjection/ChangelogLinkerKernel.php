<?php declare(strict_types=1);

namespace Symplify\ChangelogLinker\DependencyInjection;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symplify\ChangelogLinker\DependencyInjection\CompilerPass\CollectorCompilerPass;
use Symplify\PackageBuilder\DependencyInjection\CompilerPass\PublicForTestsCompilerPass;
use Symplify\PackageBuilder\HttpKernel\AbstractCliKernel;

final class ChangelogLinkerKernel extends AbstractCliKernel
{
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/../config/config.yml');
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir() . '/_changelog_linker';
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir() . '/_changelog_linker_logs';
    }

    /**
     * Order matters!
     */
    protected function build(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addCompilerPass(new PublicForTestsCompilerPass());
        $containerBuilder->addCompilerPass(new CollectorCompilerPass());
    }
}
