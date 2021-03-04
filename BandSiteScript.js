//Merch Store Script
{
var totalF = 1;
var totalK = 1;
var totalJ = 1;
var numTFC = 86;

function increaseF(){
    totalF ++;
    document.getElementById('NumF').innerHTML = totalF;
}
function decreaseF(){
    if(totalF==1){
        window.alert("Sorry, there is no band without at least on of them!")
    }else{
        totalF --;
        document.getElementById('NumF').innerHTML = totalF;
    }
}
function increaseK(){
    totalK ++;
    numTFC += 50;
    document.getElementById('NumK').innerHTML = totalK;
    document.getElementById('NumTFC').innerHTML = numTFC;
}
function decreaseK(){
    if(totalK==1){
        window.alert("Sorry, there is no band without at least on of them!")
    }else{
        totalK --;
        numTFC -=50;
        document.getElementById('NumK').innerHTML = totalK;
        document.getElementById('NumTFC').innerHTML = numTFC;
    }
}
function increaseJ(){
    totalJ ++;
    numTFC += 36;
    document.getElementById('NumJ').innerHTML = totalJ;
    document.getElementById('NumTFC').innerHTML = numTFC;
}
function decreaseJ(){
    if(totalJ==1){
        window.alert("Sorry, there is no band without at least on of them!")
    }else{
        totalJ --;
        numTFC -=36;
        document.getElementById('NumJ').innerHTML = totalJ;
        document.getElementById('NumTFC').innerHTML = numTFC;
    }
}
}

//Calculator Script
{
var operators = 0;

function updateDisplay(enteredNum){
    //Check if this is the first number added
    if(document.getElementById('display').innerHTML == "0"){
        //If so, check if it is an operator
        if((enteredNum == ("/")) || (enteredNum == ('+'))){
            window.alert('err: cannot start equation with operator');
        }else{
            document.getElementById('display').innerHTML = enteredNum;
        }
    //If not the first number    
    }else{
        //Check if it is another number
        if((enteredNum != '/') && (enteredNum != '+')){
            document.getElementById('display').innerHTML += enteredNum;
        }else{
            //If it is an operator, check if we've already had one
            if(operators != 0){
                window.alert('err: this calculator can only perform one operation');
            }else{
                operators ++;
                document.getElementById('display').innerHTML += enteredNum;
            }
        }
    }
}

function clearDisplay(){
    operators = 0;
    document.getElementById('display').innerHTML = "0";
}

function calculateDisplay(){
    //WARNING: THERE IS AN INFINITE LOOP HERE!!!

    //set up variable to hold the equation typed in the display
    var eqn = document.getElementById('display').innerHTML;
    //set up a few variables we will use to turn the equation into numbers we can perform math on
    var degree1 = 0, degree2 =0, j=0, k=eqn.length;
    //loop through characters from left to right until we hit an operator
    while((eqn.charAt(j)!='/')&&(eqn.charAt(j)!='+')){
        degree1++;
        j++;
    }
    //loop through characters from right to left until we hit an operator
    while((eqn.charAt(k-1)!='/')&&(eqn.charAt(k-1)!='+')){
        degree2++;
        k--;
    }
    
    //set up an array to hold the two operands
    var nums = [0,0];
    //loop from left to right muliplying characters by the degree to get the first operand to the correct magnitude
    for(var l=0; l < j; l++){
        nums[0] += (eqn.charAt(l) * (10**(degree1-1)))
        degree1--;
    }
    //loop from right to left muliplying characters by the degree to get the second operand to the correct magnitude
    for(var k; k < eqn.length; k++){
        nums[1] += (eqn.charAt(k) * (10**(degree2-1)))
        degree2--;
    }

    //check wich operator was selected and perform that calculation
    if(eqn.charAt(j) == '/') document.getElementById('display').innerHTML = (nums[0]/nums[1]).toFixed(1);
    if(eqn.charAt(j) == '+') document.getElementById('display').innerHTML = (nums[0]+nums[1]);
}
}

//Messages Script
{
function bandLogin(){
    var bLogin = prompt("Please enter the band password");
    if (bLogin == "TFC"){
        location.replace("BandSiteReceiveMessages.php");
    }else{
        location.replace("BandSiteHome.html");
    }
}
}