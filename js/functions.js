function givegrade(id)
{
    var name = "gradeBox-" + id;
    var box = document.getElementById(name);
    if (box.innerHTML == "")
    {
        box.innerHTML = '<fieldset data-role="controlgroup">' +
                            '<legend>Select Your Grade :</legend>' +
                            '<input type="radio" name="'+name+'" id="radio-choice-1" value="6" checked/>' +
                            '<label for="radio-choice-1">A</label>' +
                            '<input type="radio" name="'+name+'" id="radio-choice-2" value="5"/>' +
                            '<label for="radio-choice-1">B</label>' +
                            '<input type="radio" name="'+name+'" id="radio-choice-2" value="4"/>' +
                            '<label for="radio-choice-1">C</label>' +
                            '<input type="radio" name="'+name+'" id="radio-choice-2" value="3"/>' +
                            '<label for="radio-choice-1">D</label>' +
                            '<input type="radio" name="'+name+'" id="radio-choice-2" value="2"/>' +
                            '<label for="radio-choice-1">F</label>' +
                        '</fieldset>';
    } else {
        box.innerHTML = "";
    }
    return true;
}