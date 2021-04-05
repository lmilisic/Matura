/* Evaluator results colorizer script */

if (!$) { $ = django.jQuery; }

var colorizer = {

    green:  "00F269",
    yellow: "FFFB00",
    red: "F21111",
    gray: "E0E0E0",

    /* DO NOT TOUCH ANYTHING BELOW THIS LINE */
    initialize: function(){
        this.green_RGB = [
            parseInt( this.green.substr( 0, 2 ), 16 ),
            parseInt( this.green.substr( 2, 2 ), 16 ),
            parseInt( this.green.substr( 4, 2 ), 16 ) ]
        this.yellow_RGB = [
            parseInt( this.yellow.substr( 0, 2 ), 16 ),
            parseInt( this.yellow.substr( 2, 2 ), 16 ),
            parseInt( this.yellow.substr( 4, 2 ), 16 ) ]
        this.red_RGB = [
            parseInt( this.red.substr( 0, 2 ), 16 ),
            parseInt( this.red.substr( 2, 2 ), 16 ),
            parseInt( this.red.substr( 4, 2 ), 16 ) ]
    },

    tohex: function( num ){
        var ret = num.toString( 16 );
        if( ret.length < 2 ) return "0" + ret;
        return ret;
    },

    generate_color: function( color ){
        return "#" + this.tohex( color[ 0 ] ) + this.tohex( color[ 1 ] ) + this.tohex( color[ 2 ] );
    },

    mixin: function( color1, color2, perc ){
        return this.generate_color( [
            Math.round( color1[ 0 ] * ( 1.0 - perc ) + color2[ 0 ] * perc ),
            Math.round( color1[ 1 ] * ( 1.0 - perc ) + color2[ 1 ] * perc ),
            Math.round( color1[ 2 ] * ( 1.0 - perc ) + color2[ 2 ] * perc ) ] );
    },

    colorize: function(){
        this.initialize();
        var me = this;
        $( "span.colorize" ).each(function() {
            var data = $(this).html();
            if( data.indexOf( "-" ) != -1 || data.indexOf( "*" ) != -1 ){
                $(this).css( "background", "#" + me.gray );
                return;
            }
            var arr = data.replace( " ", "" ).split( "/" ), color = "#fff";
            var pts = parseFloat( arr[ 0 ] ), ptsmax = parseFloat( arr[ 1 ] );
            var ratio = pts / ptsmax;
            if( ratio < 0.5 ) color = me.mixin( me.red_RGB, me.yellow_RGB, ratio * 2 );
            else color = me.mixin( me.yellow_RGB, me.green_RGB, ( ratio - 0.5 ) * 2 );
            $(this).css( "background", color );    
        });
    }
};

$(document).ready(function(){
    colorizer.colorize()
});
