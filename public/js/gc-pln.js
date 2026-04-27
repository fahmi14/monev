const DATA_URL = "https://docs.google.com/spreadsheets/d/e/2PACX-1vSGXDPzxTdlBqjc9kNLnuzmiXrt3Bjc7Dn6H5eaP2763MibTUrp9FypsHSAMTQc6Yytnq84zdK-5EDf/pub?output=csv";

let sortState = "desc";

// PAGINATION
let currentPage = 1;
let rowsPerPage = 10;

// function loadData(){

// fetch(DATA_URL)
// .then(res=>res.text())
// .then(data=>{

// let rows = data.split(/\r?\n/).slice(1);

// let totalOpen=0;
// let totalSubmit=0;
// let totalReject=0;

// let arr = [];

// rows.forEach(row=>{

// if(!row) return;

// let col = row.split(",");

// let nama = col[0]?.replace(/^"|"$/g,'').trim();

// let open = parseInt(col[2]) || 0;
// let submit = parseInt(col[3]) || 0;
// let reject = parseInt(col[4]) || 0;

// let total = open + submit + reject;
// let progress = total ? ((submit/total)*100).toFixed(2) : 0;

// totalOpen += open;
// totalSubmit += submit;
// totalReject += reject;

// arr.push({
// nama,
// open,
// submit,
// reject,
// progress
// });

// });


// let totalAll = totalOpen + totalSubmit + totalReject;
// let progressTotal = totalAll 
// ? ((totalSubmit/totalAll)*100).toFixed(2) 
// : 0;

// document.getElementById("open").innerText = totalOpen.toLocaleString("id-ID");
// document.getElementById("submit").innerText = totalSubmit.toLocaleString("id-ID");
// document.getElementById("reject").innerText = totalReject.toLocaleString("id-ID");
// document.getElementById("progress").innerText = progressTotal + "%";
// document.getElementById("total").innerText = totalAll.toLocaleString("id-ID");


// let now = new Date();
// document.getElementById("lastUpdate").innerText =
// "Last Update: " + now.toLocaleString("id-ID");


// window.petugasData = arr;

// renderTable();

// });
// }



// RENDER TABLE
// function renderTable(){

// let data = window.petugasData;

// let start = (currentPage - 1) * rowsPerPage;
// let end = start + rowsPerPage;

// let paginated = data.slice(start, end);

// let html="";

// paginated.forEach(d=>{

// html+=`
// <tr>
// <td>${d.nama}</td>
// <td class="text-end">${d.open}</td>
// <td class="text-end">${d.submit}</td>
// <td class="text-end">${d.reject}</td>
// <td class="text-end">${d.progress}%</td>
// </tr>
// `;

// });

// document.getElementById("tablePetugas").innerHTML = html;


// // PAGE INFO
// let totalPage = Math.ceil(data.length / rowsPerPage);

// document.getElementById("pageInfo").innerText =
// "Halaman " + currentPage + " dari " + totalPage;

// }



// NEXT PAGE
function nextPage(){

let totalPage = Math.ceil(window.petugasData.length / rowsPerPage);

if(currentPage < totalPage){
currentPage++;
renderTable();
}

}



// PREV PAGE
function prevPage(){

if(currentPage > 1){
currentPage--;
renderTable();
}

}



// SORT
function sortProgress(type){

let data = window.petugasData;

if(type==="desc"){
data.sort((a,b)=>b.progress-a.progress);
}

if(type==="asc"){
data.sort((a,b)=>a.progress-b.progress);
}

currentPage = 1;
renderTable();

}



// TOGGLE SORT
function toggleSort(){

if(sortState === "desc"){
sortProgress("desc");
sortState = "asc";
}
else{
sortProgress("asc");
sortState = "desc";
}

}



// EXPORT
function exportPetugas(){

let rows = [];

rows.push([
"Nama Petugas",
"OPEN",
"SUBMITTED",
"REJECTED",
"Progress"
]);

window.petugasData.forEach(d=>{

rows.push([
d.nama,
d.open,
d.submit,
d.reject,
d.progress
]);

});

let csv = "data:text/csv;charset=utf-8,sep=;\n";

rows.forEach(r=>{
csv += r.join(";") + "\n";
});

let link = document.createElement("a");

link.setAttribute("href", encodeURI(csv));
link.setAttribute("download", "gc-pln.csv");

document.body.appendChild(link);

link.click();

}


loadData();
setInterval(loadData,300000);