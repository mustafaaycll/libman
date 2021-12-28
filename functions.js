function studentCheck() {
    if (document.getElementById('student').checked) {
        document.getElementById('ifstudent').style.display = 'block';
    }
    else document.getElementById('ifstudent').style.display = 'none';

}

function staffCheck() {
    if (document.getElementById('staff_member').checked) {
        document.getElementById('ifstaff').style.display = 'block';
    }
    else document.getElementById('ifstaff').style.visibility = 'hidden';

}


function whichChecked() {

    if (document.getElementById('student').checked){
        document.getElementById('ifstudent').style.display = 'block';
    }
    else document.getElementById('ifstudent').style.display = 'none';

    if (document.getElementById('staff_member').checked) {
        document.getElementById('ifstaff').style.display = 'block';
    }
    else document.getElementById('ifstaff').style.display = 'none';
}