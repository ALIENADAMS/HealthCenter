//set position for every 10 box of hemoglobin diagram
function setPositionHemoglobin()
{
    for(var i = 0; i < 10; i++)
    {
        document.getElementById('hemoglobin' + i).style.left = i * 130 + 'px';
    }
}

//set result if not in reference
function setResultAlert()
{
   var reference_min_value = document.getElementById('reference_min_value').innerText;
   var reference_max_value = document.getElementById('reference_max_value').innerText;
   var test_value = document.getElementById('value_of_test').innerText;

   if(test_value < reference_min_value || test_value > reference_max_value)
   {
    document.getElementById('value_of_test').style.color = 'red';
   }
}