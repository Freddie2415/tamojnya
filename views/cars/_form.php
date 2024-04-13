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

    <?php $form = ActiveForm::begin(['id' => 'car-form']); ?>
    <?php echo $form->field($model, 'country_id')->dropDownList(
        Countries::fetchData(),
        ['prompt' => 'Выберите страну', 'id' => 'country-dropdown', 'required' => true]
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

    <?= $form->field($model, 'car_number')->textInput(['maxlength' => true, 'required' => true]) ?>
    <div class="invalid-feedback" id="carNumberErrorMessage"></div>
    <?= $form->field($model, 'model')->textInput(['maxlength' => true, 'required' => true]) ?>

    <?= $form->field($model, 'phoneNumber')->textInput(['maxlength' => true, 'required' => true]) ?>

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

<script>$(document).ready(function () {
        // слушаем событие изменения в элементе select
        $('#country-dropdown').change(function () {
            resetCarNumberValidation()
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

        // Слушаем изменения в поле ввода номера авто
        $('#cars-car_number').keyup(function () {
            validateCarNumber(); // Выполняем валидацию при вводе номера авто
        });

        // Функция для выполнения кастомной валидации номера авто
        function validateCarNumber() {
            if ($('#country-dropdown').val() !== '242') {
                return true;
            }

            var selectedType = $('#carNumberTypeDropdown').val(); // Получаем выбранный тип номера
            var carNumber = $('#cars-car_number').val(); // Получаем введенный номер авто

            // Определяем регулярное выражение для валидации в зависимости от выбранного типа
            var regex;
            if (selectedType === '1') {
                regex = /^[0-9]{2} [A-Za-z] [0-9]{3} [A-Za-z]{2}$/; // Регулярное выражение для физического лица
            } else if (selectedType === '2') {
                regex = /^[0-9]{2} [0-9]{3} [A-Za-z]{3}$/; // Регулярное выражение для юридического лица
            } else if (selectedType === '3') {
                regex = /^[0-9]{2} [A-Za-z] [0-9]{6}$/; // Регулярное выражение для иностранного номера
            } else if (selectedType === '4') {
                regex = /^[0-9]{2} [A-Za-z] [0-9]{6}$/; // Регулярное выражение для юридического номера
            }

            // Выполняем валидацию
            if (regex.test(carNumber)) {
                $('#cars-car_number').removeClass('is-invalid'); // Удаляем класс ошибки
                $('#carNumberErrorMessage').text(''); // Очищаем сообщение об ошибке
                $('#carNumberErrorMessage').hide(); // Скрываем блок с сообщением об ошибке, если был показан
                return true;
            } else {
                $('#cars-car_number').addClass('is-invalid'); // Добавляем класс ошибки
                $('#carNumberErrorMessage').text('Некорректный номер автомобиля'); // Устанавливаем текст сообщения об ошибке
                $('#carNumberErrorMessage').show(); // Показываем блок с сообщением об ошибке
                return false;
            }
        }

        // Функция для сброса валидации номера авто
        function resetCarNumberValidation() {
            $('#cars-car_number').removeClass('is-invalid'); // Удаляем класс ошибки
            $('#cars-car_number').removeClass('was-validated'); // Удаляем класс was-validated
            $('#carNumberErrorMessage').text(''); // Очищаем сообщение об ошибке
            $('#carNumberErrorMessage').hide(); // Скрываем блок с сообщением об ошибке, если был показан
        }

        $('#car-form').submit(function (event) {
            // Выполняем валидацию номера авто перед отправкой формы
            if (!validateCarNumber()) {
                // Если валидация не прошла успешно, отменяем отправку формы
                event.preventDefault();
            }
        });
    });
</script>