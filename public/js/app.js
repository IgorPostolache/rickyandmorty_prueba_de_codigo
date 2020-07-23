import API from './api.js';

$(document).ready(function() {
    list();
});

const api = new API();

class Episodes {
    constructor({id, name}) {
        this.id = id;
        this. name = name;
        this.render();
    }
    render() {
        $('.card')
    }

}

async function initApp(ID) {
    
    const episodeData = await api.getEpisodes();
    let episodios = episodeData.results;
    let episodiosImg = ['img/1.jpg', 'img/2.jpg', 'img/3.jpg', 'img/4.jpg', 'img/5.jpg', 'img/6.jpg', 'img/7.jpg'];
    
    $.each(episodios, function(i){
        var templateString = '<div class="col-6 col-md-3"><div class="card small hoverable" episode><div class="card-image"><img class="materialboxed" width="650" src='+episodiosImg[Math.floor(Math.random() * 7)]+'></div><div class="card-content"><p>'+episodios[i].name+'</p>'+episodios[i].episode+'<p></p></div><div class="card-action"><a href='+episodios[i].url+'>'+episodios[i].url+'</a></div></div></div>';
        $('.episodes').append(templateString);
    })
    $('.materialboxed').materialbox();
    
}
initApp();

var list = function() {
    var table = $('#episodiosTabla tbody');
    var dataTable =  $('#episodiosTabla').DataTable( {
        "ajax": {
            url: "https://rickandmortyapi.com/api/episode/",
            method: "GET",
            dataSrc: "results",
        },
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        },
        responsive: true,
        dom: 'Bfrtilp',
        buttons: [
            {
                extend: "excelHtml5",
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success'
            },
            {
                extend: "pdfHtml5",
                text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                titleAttr: 'Exportar a Pdf',
                className: 'btn btn-danger'
            },
            {
                extend: "print",
                text: '<i class="fa fa-print" aria-hidden="true"></i>',
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            }
        ],
        columns: [
                    { data: "id" },
                    { data: "air_date" },
                    { data: "episode" },
                    { data: "name" },
                    { data: "characters.length" },
                    { data: "url" },
                ]
    } );
}