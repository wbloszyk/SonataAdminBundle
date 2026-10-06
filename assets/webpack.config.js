const Encore = require('@symfony/webpack-encore');

function getSonataWebpackConfig() {
    // Resetujemy stan Encore, aby stworzyć czystą, odizolowaną konfigurację
    Encore.reset();

    Encore
        .setOutputPath('public/sonata_build/')
        .setPublicPath('/sonata_build/')

        .addEntry('sonata_admin', './assets/sonata_admin/js/app.js')

        .disableSingleRuntimeChunk()
        .cleanupOutputBeforeBuild()
        .enableSourceMaps(!Encore.isProduction())
        .enableVersioning(Encore.isProduction())

        .enableSassLoader()
        .autoProvidejQuery()
    ;

    return Encore.getWebpackConfig();
}

module.exports = getSonataWebpackConfig;
