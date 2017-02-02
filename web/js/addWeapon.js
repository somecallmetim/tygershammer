jQuery(document).ready(function($) {
    $('.js-dmg-determiner option[value="dice"]').attr("selected", true);

    var dmgDeterminer =$('.js-dmg-determiner :selected').val();
    var maxDieValue = null;
    var numberOfDice = null;
    var staticDamage = null;

    $('.js-static-dmg-field').toggle();
    $('.js-dmg-determiner').change(function (){
        $('.js-dice-dmg-field, .js-static-dmg-field').toggle('.js-dice-dmg-field .js-static-dmg-field');

        dmgDeterminer =$('.js-dmg-determiner :selected').val();

        //saves the state of the users current selection so they're persistent if the user switches back
        //also sets the fields themselves to 'null' to avoid issues in the database
        if(dmgDeterminer == 'dice'){
            staticDamage = $('.js-static-dmg').val();

            $('.js-static-dmg').val(null);

            if(maxDieValue != null && numberOfDice != null){
                $('.js-max-die-value').val(maxDieValue);
                $('.js-number-of-dice').val(numberOfDice);
            }
        }else if(dmgDeterminer == 'static'){
            maxDieValue = $('.js-max-die-value :selected').val();
            numberOfDice = $('.js-number-of-dice').val();

            $('.js-max-die-value').val('Please select a value');
            $('.js-number-of-dice').val(null);

            if(staticDamage != null){
                $('.js-static-dmg').val(staticDamage);
            }
        }else {
            throw new Error();
        }
    });
});