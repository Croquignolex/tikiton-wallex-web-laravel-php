function setValidIndicator(element){
    element.classList.remove('form-invalid');
    element.classList.add('form-valid');
}

function setInvalidIndicator(element){
    element.classList.remove('form-valid');
    element.classList.add('form-invalid');
}

function validation(element){
    let isValid = true;

    if(element.tagName === 'INPUT')
    {
        let type = element.type;
        let value = element.value;

        if(type === 'email')
        {
            let match = value.match(/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/i);
            isValid = match && isMinMaxValidation(element);
        }
        else if(type === 'number')
        {
            isValid = isIntegerValidation(element) && isMinMaxValidation(element);
        }
        else if(type === 'password')
        {
            if(element.name === 'password_confirmation')
            {
                let password = document.getElementById('password');
                isValid = value === password.value && isMinMaxValidation(element);
            }
            else isValid = isMinMaxValidation(element);
        }
        else if(type === 'text') isValid = isMinMaxValidation(element);
    }
    else if(element.tagName === 'TEXTAREA')
    {
        isValid = isMinMaxValidation(element);
    }
    else if(element.tagName === 'SELECT')
    {
        isValid = isIntegerValidation(element);
    }

    return isValid;
}

function isMinMaxValidation(element){
    let length = element.value.length;
    let minLength = element.minLength;
    let maxLength = element.maxLength;

    return !(length < minLength || length > maxLength);
}

function isIntegerValidation(element){
    return !(!element.value.match(/^[0-9.]+$/));
}

function isFormValidation(element){
    let isValid = true;

    for(let i = 0; i < element.length; i++)
    {
        if(!(element[i].type === 'hidden') && !(element[i].type === 'submit') && (element[i].dataset.validate === 'true'))
        {
            if(validation(element[i])) setValidIndicator(element[i]);
            else
            {
                isValid = false;
                setInvalidIndicator(element[i]);
            }
        }
    }

    return isValid;
}