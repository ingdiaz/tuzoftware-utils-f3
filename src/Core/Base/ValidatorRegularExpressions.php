<?php
namespace Core\Base;
class ValidatorRegularExpressions
{

    const ALPHA_MX_SPACES='/^[A-Za-zÑñ\sáéíóúÁÉÍÓÚ]+\z/m';
    const ALPHA_NUMERIC_MX_SPACES='/^[0-9A-Za-zÑñ\sáéíóúÁÉÍÓÚ]+\z/m';

    const NUMERIC='/^[0-9]+\z/m';

}