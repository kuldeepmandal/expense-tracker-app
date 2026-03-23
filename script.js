function addExpense() {
    let desc = document.getElementById("desc").value;
    let amount = document.getElementById("amount").value;

    if (desc === "" || amount === "") {
        alert("Please fill all fields");
        return;
    }

    let list = document.getElementById("list");

    let li = document.createElement("li");
    li.textContent = desc + " - Rs " + amount;

    list.appendChild(li);

    document.getElementById("desc").value = "";
    document.getElementById("amount").value = "";
}