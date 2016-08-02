import Trianglify from 'trianglify'
import $ from 'jquery'

export default class TriangularBackground
{
    constructor() {
        let colors = this.constructor.getAvailableColors()
        this.color = colors[Math.floor(Math.random() * colors.length)]

        this.configuration = {
            variance: 1,
            x_colors: this.color.color,
            seed: this.constructor._generateSeed(),
            cell_size: Math.floor((Math.random() * 150) + 75),
        }
    }

    static getAvailableColors() {
        return [
            { color: 'YlGnBu', class: 'primary' },
            { color: 'YlOrRd', class: 'warning' },
            { color: 'PuOr', class: 'warning' },
            { color: 'GnBu', class: 'primary' },
            { color: 'YlOrBr', class: 'warning' },
            { color: 'Blues', class: 'primary' },
            { color: 'Reds', class: 'danger' },
        ]
    }

    generateImage() {
        var config = this.configuration
        config.width = window.innerWidth
        config.height = window.innerHeight

        return Trianglify(config)
    }

    setImage() {
        let triangle = this.generateImage()
        $('body').css('background-image', 'url(' + triangle.png() + ')')
        $.each($('.btn-background-color'), (_, btn) => {
            let button = $(btn)
            let defaultClass = 'btn-' + button.data('default-color') + '-outline'
            button.removeClass(defaultClass)
            button.addClass('btn-' + this.color.class + '-outline')
        })
    }

    registerResize() {
        var that = this

        window.onresize = function() {
            that.setImage()
        }
    }

    static _generateSeed(length = 6) {
        var text = ''
        var characterSet = 'ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvwxyz0123456789'

        for (var i = 0; i < length; i++) {
            text += characterSet.charAt(Math.floor(Math.random() * characterSet.length))
        }

        return text
    }
}