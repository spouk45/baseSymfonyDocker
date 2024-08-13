const path = require('path');

module.exports = {
  entry: './assets/js/app.js', // Point d'entrée principal de ton application
  output: {
    filename: 'bundle.js', // Nom du fichier de sortie
    path: path.resolve(__dirname, 'public/build'), // Répertoire de sortie
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          'style-loader', // Injecte les styles dans le DOM
          'css-loader', // Interprète les @import et les URL() comme des require()/import()
          'sass-loader', // Compile le SCSS en CSS
        ],
      },
    ],
  },
};
