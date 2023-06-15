const path = require('path');

module.exports = {
    entry: './public/assets/app.js',
    mode: 'development',
    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, 'public/assets')
    },
    module: {
        rules: [
            {
                test: /\.(scss)$/,
                use: [{
                    // вставить CSS на страницу
                    loader: 'style-loader'
                }, {
                    // переводит CSS в модули CommonJS
                    loader: 'css-loader'
                }, {
                    // Выполнить действия postcss
                    loader: 'postcss-loader',
                    options: {
                        // `postcssOptions` требуется для postcss 8.x;
                        // если Вы используете postcss 7.x пропустите ключ
                        postcssOptions: {
                            // плагины postcss, можно экспортировать в postcss.config.js
                            plugins: function () {
                                return [
                                    require('autoprefixer')
                                ];
                            }
                        }
                    }
                }, {
                    // компилирует Sass в CSS
                    loader: 'sass-loader'
                }]
            }
        ]
    }
};