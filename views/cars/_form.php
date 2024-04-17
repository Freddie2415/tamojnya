<?php

use app\models\Countries;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// use dosamigos\datetimepicker\DateTimePicker;


// use kartik\datetime\DateTimePicker;

/** @var yii\web\View $this */
/** @var app\models\Cars $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cars-form ">

    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($model, 'country_id')->dropDownList(
        Countries::fetchData(),
        ['prompt' => Yii::t('main', 'Выберите страну'), 'id' => 'country-dropdown']
    )->label(Yii::t('main', 'Страна автомобиля'));
    ?>
    <div id="typeDropdownContainer" style="display: none;">

        <label class="control-label"><?= Yii::t('main', 'Тип номера авто') ?></label>
        <?= Html::dropDownList('type', '2', [
            '1' => Yii::t('main', 'Физическое лицо номер'),
            '2' => Yii::t('main', 'Юридическое лицо номер'),
            '3' => Yii::t('main', 'Иностранный номер (желтый)'),
            '4' => Yii::t('main', 'Юридический номер (зеленый)'),
        ], ['class' => 'form-control mb-2', 'id' => 'carNumberTypeDropdown']) ?>
    </div>

    <?= $form->field($model, 'car_number') ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phoneNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'arrivedDate')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Enter datetime ...'],
        'readonly' => true,

        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:ss', // format according to your requirement
            'defaultDate' => date('Y-m-d H:i:s'), // set default datetime to today's date and current time
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('main', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(document).ready(function () {
        // Attach change event listener to the dropdown
        $('#country-dropdown').on('change', function () {
            // Get the selected value
            var selectedCountryId = $(this).val();
            if (parseInt(selectedCountryId) === 242) {
                // If yes, show the type dropdown
                document.getElementById('typeDropdownContainer').style.display = 'block';
            } else {
                // If not, hide the type dropdown
                document.getElementById('typeDropdownContainer').style.display = 'none';
            }
            // Perform actions based on the selected value
            console.log('Selected country ID:', selectedCountryId);
            // You can replace the console.log with your own logic
        });
    });
</script>


<script>
    // Function to apply input mask based on selected dropdown value
    // function applyInputMask(selectedValue) {
    //     // Remove existing input mask (if any)
    //     Inputmask.remove(document.getElementById('carNumber'));

    //     // Apply input mask based on selected value
    //     switch (selectedValue) {
    //         case '1': // Standard Car Number (e.g., AB123CD)
    //             Inputmask({ mask: 'AA999AA' }).mask(document.getElementById('carNumber'));
    //             break;
    //         case '2': // Car Number with Region Code (e.g., 12ABC123)
    //             Inputmask({ mask: '99AAA999' }).mask(document.getElementById('carNumber'));
    //             break;
    //         case '3': // International Car Number (e.g., ABC-123)
    //             Inputmask({ mask: 'AAA-999' }).mask(document.getElementById('carNumber'));
    //             break;
    //         default:
    //             // No input mask for other values
    //             break;
    //     }
    // }

    // // Event listener for dropdown change
    // document.getElementById('carNumberType').addEventListener('change', function() {
    //     var selectedValue = this.value;
    //     applyInputMask(selectedValue);
    // });

    // // Apply input mask based on initial selected value
    // var initialSelectedValue = document.getElementById('carNumberType').value;
    // applyInputMask(initialSelectedValue);
</script>

<script>
    // Function to apply input mask based on selected dropdown value
    // function applyInputMask(selectedValue) {
    //     // Remove existing input mask (if any)
    //     Inputmask.remove(document.getElementById('carNumber'));

    //     // Apply input mask based on selected value
    //     switch (selectedValue) {
    //         case '1': // Физическое лицо номер
    //             Inputmask({
    //                 mask: 'AA999AA'
    //             }).mask(document.getElementById('carNumber'));
    //             break;
    //         case '2': // Юридическое лицо номер
    //             Inputmask({
    //                 mask: '99AAA999'
    //             }).mask(document.getElementById('carNumber'));
    //             break;
    //         case '3': // Иностранный номер (желтый)
    //             Inputmask({
    //                 mask: 'AAA-999'
    //             }).mask(document.getElementById('carNumber'));
    //             break;
    //         case '4': // Юридический номер (зеленый)
    //             Inputmask({
    //                 mask: 'AA999999'
    //             }).mask(document.getElementById('carNumber'));
    //             break;
    //         default:
    //             // No input mask for other values
    //             break;
    //     }
    // }

    // // Event listener for dropdown change
    // document.getElementById('carNumberTypeDropdown').addEventListener('change', function() {
    //     var selectedValue = this.value;
    //     applyInputMask(selectedValue);
    // });

    // // Apply input mask based on initial selected value
    // var initialSelectedValue = document.getElementById('carNumberTypeDropdown').value;
    // applyInputMask(initialSelectedValue);
</script>
<script>$(document).ready(function () {
        // слушаем событие изменения в элементе select
        $('#country-dropdown').change(function () {
            $('#cars-car_number').unmask();
            $('label[for="cars-car_number"]').text('Номер автомобиля');
            $('#cars-car_number').attr('placeholder', '');

            if (document.getElementById('typeDropdownContainer').style.display === 'block') {
                $('#carNumberTypeDropdown').val('2').trigger('change');
            } else {
                $('#cars-car_number').val("");
            }
        })

        $('#cars-car_number').on('keypress', function (event) {
            var $input = $(this);
            setTimeout(function () {
                $input.val($input.val().toUpperCase());
            }, 0);
        });

        $('#carNumberTypeDropdown').change(function () {
            // получаем выбранное значение
            var value = $(this).val();
            // удаляем предыдущую маску, если она есть
            $('#cars-car_number').unmask();
            console.log(value)
            // применяем новую маску в зависимости от выбранного значения
            if (value === '1') {
                $('#cars-car_number').attr('placeholder', '01 A 123 BC');
                $('label[for="cars-car_number"]').text('Номер автомобиля (пример: 01 A 123 BC)');
                $('#cars-car_number').mask('99 A 999 ZZ', {
                    translation: {
                        'A': {pattern: /[A-Za-z]/},
                        'Z': {pattern: /[A-Za-z]/},
                        '9': {pattern: /\d/}
                    }
                });

            } else if (value === '2') {
                $('#cars-car_number').attr('placeholder', '01 123 ABC');
                $('label[for="cars-car_number"]').text('Номер автомобиля (пример: 01 123 ABC)');
                $('#cars-car_number').mask('99 999 ZZZ', {
                    translation: {
                        'A': {pattern: /[A-Za-z]/},
                        'Z': {pattern: /[A-Za-z]/},
                        '9': {pattern: /\d/}
                    }
                });
            } else if (value === '3') {
                $('#cars-car_number').attr('placeholder', '10 M 012345');
                $('label[for="cars-car_number"]').text('Номер автомобиля (пример: 10 M 012345)');
                $('#cars-car_number').mask('99 A 999999', {
                    translation: {
                        'A': {pattern: /[A-Za-z]/},
                        'Z': {pattern: /[A-Za-z]/},
                        '9': {pattern: /\d/}
                    }
                });
            } else if (value === '4') {
                $('#cars-car_number').attr('placeholder', '01 H 012345');
                $('label[for="cars-car_number"]').text('Номер автомобиля (пример: 01 H 012345)');
                $('#cars-car_number').mask('99 A 999999', {
                    translation: {
                        'A': {pattern: /[A-Za-z]/},
                        'Z': {pattern: /[A-Za-z]/},
                        '9': {pattern: /\d/}
                    }
                });
            }

        });
    });
</script>