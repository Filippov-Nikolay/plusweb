function openbox(box) {
    display = document.getElementById(box).style.display
    if(display=='none') {
        document.getElementById(box).style.display='block'
        document.getElementById('body').style.overflow='hidden'
    } else {
        document.getElementById(box).style.display='none'
        document.getElementById('body').style.overflow='auto'
    }
}

function selected(idSelect) {
    var select = document.getElementById(idSelect)
    select.addEventListener('change', function(){
        var getValue = this.value;
        console.log(getValue)
        if(idSelect == 'selects1') {
            if(getValue == 'other') {
                document.getElementById('forms-text1').style.display='block'
            } else {
                document.getElementById('forms-text1').style.display='none'
            }
        } else {
            if(getValue == 'other') {
                document.getElementById('forms-text2').style.display='block'
            } else {
                document.getElementById('forms-text2').style.display='none'
            }
        }
    });
}
