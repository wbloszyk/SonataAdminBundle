import path  from 'path';

function getSonataWebpackConfig(Encore)
{
  Encore.reset();
  Encore
    .setOutputPath('public/sonata_build/')
    .setPublicPath('/sonata_build/')
    .setManifestKeyPrefix('bundles/sonataadmin')

    .addEntry('sonata_admin', './assets/sonata_admin/js/app.js')

    .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .enableSassLoader()
    .autoProvidejQuery()
  ;

  const config = Encore.getWebpackConfig();

  // --- FORCE LOCAL NODE_MODULES ---
  config.resolve = config.resolve || {};
  config.resolve.modules = [
    // first search in local node_modules
    path.resolve(import.meta.dirname, '../../assets/sonata_admin/node_modules'),
    'node_modules' // fallback
  ];

  return config;
}

export default getSonataWebpackConfig;
