const path = require('path');

module.exports = {
  entry: './App/js/index.js',
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'public/js')
  },
  module: {
    rules: [
      {
        test: /\.css$/i,
        use: ['postcss-loader'],
      },
    ],
  },
  mode: 'development'
};