// declare necessary variables
let arr_with_fields = ['1a', '1b', '1c', '2a', '2b', '2c', '3a', '3b', '3c']; // массив всех значений игрового поля
let win_arr1 = ['1a', '1b', '1c'];
let win_arr2 = ['2a', '2b', '2c'];
let win_arr3 = ['3a', '3b', '3c'];
let win_arr4 = ['1a', '2a', '3a'];
let win_arr5 = ['1b', '2b', '3b'];
let win_arr6 = ['1c', '2c', '3c'];
let win_arr7 = ['1a', '2b', '3c'];
let win_arr8 = ['1c', '2b', '3a'];
let arr_of_comp_moves = [];
let arr_of_user_moves = [];
let game_done = false;

// checks that arr2 has the same values as arr1 (but arr2 can have some extra values that arr1 doesnt have), returns bool
function compareArrays(arr1, arr2) {
	var res_arr = []; // будет добавлять сюда совпадающие значения двух массивов
	for (var i=0; i<arr1.length; i++) {
		for (var j =0; j<arr2.length; j++) {
			if (arr1[i] === arr2[j]) {
					res_arr.push(arr1[i]);
			}
		}
	}
	if ( res_arr.length === arr1.length && res_arr.every((element, index) => element === arr1[index]) ) {
		return true;
	} 
	return false; // можно без else
}

// f-n returns 'a' array with only those values that are absent in b array
function arrayDiff(a, b)
{
  // let c = a;
  for (let i = 0; i < a.length;  i++) {
    for (let k = 0;  k < b.length;  k++) {
      if ( a[ i] ===  b[ k]) {
				a.splice(i, 1);
      }
    }
  }
  return  a;
}

// f-n returns arrat with values that are the same in both arrays (analogue of php array_intersect)
function array_intersect(array1, array2)
{
   var result = array1.filter(function(n) {
      return array2.indexOf(n) !== -1;
   });
   return result;
}

// analogue of php in_array, needle as string
function inArray(needle, haystack) {
  var length = haystack.length;
  for(var i = 0; i < length; i++) {
      if(haystack[i] == needle) return true;
  }
  return false;
}

// returns true if haystack array contains value/s of needle array (inArray for arrays)
function arrayInArray(haystack, needle) {
	for (let i = 0; i< haystack.length; i++) {
		for (let k = 0; k < needle.length; k++) {
			if (haystack[i] == needle[k]) {
				return true;
			}
		}
	}
	return false;
}

function user_move() {

  this.src = "img/x.gif"; // display X image when clicking on any field
  var userMove = $(this).attr('id');
  
  // remove from fields
  let index = arr_with_fields.indexOf(userMove);
  if (index > -1) { // only splice array when item is found
    arr_with_fields.splice(index, 1); // 2nd parameter means remove one item only
  }

  // add to user moves
  arr_of_user_moves.push(userMove);
  console.log("user_moves: " + arr_of_user_moves);
  console.log("fields after user move: " + arr_with_fields);

  // check if someone won or tie
  check_game_over();
}

function computer_move() {

   // arrays against quick win of user
  let arr1 = array_intersect(arr_of_user_moves, win_arr1);
  let arr2 = array_intersect(arr_of_user_moves, win_arr2);
  let arr3 = array_intersect(arr_of_user_moves, win_arr3);
  let arr4 = array_intersect(arr_of_user_moves, win_arr4); 
  let arr5 = array_intersect(arr_of_user_moves, win_arr5);
  let arr6 = array_intersect(arr_of_user_moves, win_arr6);
  let arr7 = array_intersect(arr_of_user_moves, win_arr7);
  let arr8 = array_intersect(arr_of_user_moves, win_arr8);

  // arrays for own winning strategies
  let ar1 = array_intersect(arr_of_comp_moves, win_arr1);
  let ar2 = array_intersect(arr_of_comp_moves, win_arr2);
  let ar3 = array_intersect(arr_of_comp_moves, win_arr3);
  let ar4 = array_intersect(arr_of_comp_moves, win_arr4); 
  let ar5 = array_intersect(arr_of_comp_moves, win_arr5);
  let ar6 = array_intersect(arr_of_comp_moves, win_arr6);
  let ar7 = array_intersect(arr_of_comp_moves, win_arr7);
  let ar8 = array_intersect(arr_of_comp_moves, win_arr8);
  
    // follow own winning strategy
  if (ar1.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr1, arr_of_comp_moves))) {
    var compMove = arrayDiff(win_arr1, arr_of_comp_moves);

  } else if (ar2.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr2, arr_of_comp_moves))) {
    var compMove = arrayDiff(win_arr2, arr_of_comp_moves);
  
  } else if (ar3.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr3, arr_of_comp_moves))) {
    var compMove = arrayDiff(win_arr3, arr_of_comp_moves);

  } else if (ar4.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr4, arr_of_comp_moves))) {
    var compMove = arrayDiff(win_arr4, arr_of_comp_moves);

  } else if (ar5.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr5, arr_of_comp_moves))) {
    var compMove = arrayDiff(win_arr5, arr_of_comp_moves);

  } else if (ar6.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr6, arr_of_comp_moves))) {
    var compMove = arrayDiff(win_arr6, arr_of_comp_moves);

  } else if (ar7.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr7, arr_of_comp_moves))) {
    var compMove = arrayDiff(win_arr7, arr_of_comp_moves);

  } else if (ar8.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr8, arr_of_comp_moves))) {
    var compMove = arrayDiff(win_arr8, arr_of_comp_moves);

  // then check against quick win of user
  } else if (arr1.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr1, arr_of_user_moves))) {
    var compMove = arrayDiff(win_arr1, arr_of_user_moves);

  } else if (arr2.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr2, arr_of_user_moves))) {
    var compMove = arrayDiff(win_arr2, arr_of_user_moves);

  } else if (arr3.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr3, arr_of_user_moves))) {
    var compMove = arrayDiff(win_arr3, arr_of_user_moves);
    
  } else if (arr4.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr4, arr_of_user_moves))) {
    var compMove = arrayDiff(win_arr4, arr_of_user_moves);

  } else if (arr5.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr5, arr_of_user_moves))) {
    var compMove = arrayDiff(win_arr5, arr_of_user_moves);

  } else if (arr6.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr6, arr_of_user_moves))) {
    var compMove = arrayDiff(win_arr6, arr_of_user_moves);

  } else if (arr7.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr7, arr_of_user_moves))) {
    var compMove = arrayDiff(win_arr7, arr_of_user_moves);

  } else if (arr8.length == 2 && arrayInArray(arr_with_fields, arrayDiff(win_arr8, arr_of_user_moves))) {
    var compMove = arrayDiff(win_arr8, arr_of_comp_moves); // array
 
    // if nothing matched, just choose random move
  } else {
    var compMove = arr_with_fields[Math.floor(Math.random() * arr_with_fields.length)]; // string
  }
  
  // remove from fields
  compMove = compMove.toString(); // array to string
  console.log("comp move is ", compMove);
  let index1 = arr_with_fields.indexOf(compMove);
  if (index1 > -1) {
    arr_with_fields.splice(index1, 1);
  }

  // add to comp moves
  arr_of_comp_moves.push(compMove);
  
  // redeclare bcs arrayDiff f-n changed win_arr values
  win_arr1 = ['1a', '1b', '1c'];
  win_arr2 = ['2a', '2b', '2c'];
  win_arr3 = ['3a', '3b', '3c'];
  win_arr4 = ['1a', '2a', '3a'];
  win_arr5 = ['1b', '2b', '3b'];
  win_arr6 = ['1c', '2c', '3c'];
  win_arr7 = ['1a', '2b', '3c'];
  win_arr8 = ['1c', '2b', '3a'];

  // show comp move on frontend as zero image
  $("#" + compMove).attr("src", "img/o.gif");
  
  // delete event handlers
  var elem = document.getElementById(compMove);
  elem.removeEventListener("click", user_move);
  elem.removeEventListener("click", computer_move);

  check_game_over();
}

// можно добавить в эту ф-цию и проверку выигрыша игрока или компа
function check_game_over() {

  var result_field = document.getElementById('result_field');
  var comp_vict_field = document.getElementById('comp_vict_field');
  var user_vict_field = document.getElementById('user_vict_field');
  var ties_field = document.getElementById('ties_field');

  // check if user won
   if ( compareArrays(win_arr1, arr_of_user_moves) || compareArrays(win_arr2, arr_of_user_moves) || compareArrays(win_arr3, arr_of_user_moves) || compareArrays(win_arr4, arr_of_user_moves) || compareArrays(win_arr5, arr_of_user_moves) || compareArrays(win_arr6, arr_of_user_moves) || compareArrays(win_arr7, arr_of_user_moves) || compareArrays(win_arr8, arr_of_user_moves) ) {
     result_field.innerHTML = "User won!";
     let user_victories = getCookie("userVictories") ? getCookie("userVictories") : 0; // нужно еще раз здесь вытянуть из куков переменную userVictories, иначе не видит для куки
     user_victories++;
     user_vict_field.innerHTML = user_victories;
     setCookie("userVictories", user_victories, 60);
     game_done = true;
   }

   // check if comp won
   if ( compareArrays(win_arr1, arr_of_comp_moves) || compareArrays(win_arr2, arr_of_comp_moves) || compareArrays(win_arr3, arr_of_comp_moves) || compareArrays(win_arr4, arr_of_comp_moves) || compareArrays(win_arr5, arr_of_comp_moves) || compareArrays(win_arr6, arr_of_comp_moves) || compareArrays(win_arr7, arr_of_comp_moves) || compareArrays(win_arr8, arr_of_comp_moves) ) {
    result_field.innerHTML = "Computer won!";
    let comp_victories = getCookie("compVictories") ? getCookie("compVictories") : 0; // нужно еще раз здесь вытянуть из куков переменную comp_victories, иначе не видит для куки
    comp_victories++;
    console.log("comp victories at the end: ", comp_victories);
    comp_vict_field.innerHTML = comp_victories;
    setCookie("compVictories", comp_victories, 60); // установим куку на час
    // document.cookie = "compVictories=" + comp_victories;
    game_done = true;
  }

  // check for tie
  if (!arr_with_fields.length && !game_done) {
    result_field.innerHTML = "Tie!";
    let ties = getCookie("ties") ? getCookie("ties") : 0; // нужно еще раз здесь вытянуть из куков переменную ties, иначе не видит для куки
    ties++;
    ties_field.innerHTML = ties;
    setCookie("ties", ties, 60); // установим куку на час
    game_done = true;
  }

  // if game over, block ability to click on cells
  if (game_done) {
    for (var i = 0; i < cell_elements.length; i++) {
      cell_elements[i].removeEventListener("click", computer_move);
      cell_elements[i].removeEventListener("click", user_move);
    } 
  }
}

// cookies for numbers of victories
function setCookie(cname, cvalue, exmin) {
  const d = new Date();
  d.setTime(d.getTime() + (exmin * 60 * 1000)); // how many minutes
  let expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let ca = document.cookie.split(';');
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookie() {
  let comp_victories = getCookie("compVictories") ? getCookie("compVictories") : 0;
  let user_victories = getCookie("userVictories") ? getCookie("userVictories") : 0;
  let ties = getCookie("ties") ? getCookie("ties") : 0;
  console.log("comp victories at the start", comp_victories)
  console.log("user victories at the start", user_victories)
  var comp_vict_field1 = document.getElementById('comp_vict_field');
  var user_vict_field1 = document.getElementById('user_vict_field');
  var ties_field1 = document.getElementById('ties_field');
  if (comp_victories != 0) {
    comp_vict_field1.innerHTML = comp_victories; // так вставляет кол-во побед в табл стат-ки
  }
  if (user_victories != 0) {
    user_vict_field1.innerHTML = user_victories;
  }
  if (ties != 0) {
    ties_field1.innerHTML = ties;
  }
}

