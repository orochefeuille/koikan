let homeH2 = document.getElementById("homeH2");

function reverseString(str) {
    str = str.textContent;
    var newString = "";
    for (var i = str.length - 1; i >= 0; i--) {
        newString += str[i];
    }
    return newString;
}
homeH2.textContent = reverseString(homeH2);