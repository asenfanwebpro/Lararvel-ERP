<?php

use Illuminate\Database\Seeder;

class ProtocolloFormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('formbuilder')->insert([
            'company'   => 'Medmar Navi SpA',
            'section'   => 'Segreteria',
            'formhtml'  => '<label for="tipologia">Tipoologia</label>
                            <select class="form-control" id="tipologia" name="tipologia">
                                <option value="Ingresso">Ingresso</option>
                                <option value="Uscita">Uscita</option>
                            </select>,<label for="ricezione">Data Ricezione</label>
                            <input type="date" class="form-control it-date-datepicker hasDatepicker" name="ricezione" id="ricezione" placeholder="inserisci la data in formato gg/mm/aaaa">,<label for="mittente">Mittente</label>
                            <input type="text" class="form-control" name="mittente" id="mittente" placeholder="Mittente" required="">,<label for="destinatario">Destinatario</label>
                            <input type="text" class="form-control" name="destinatario" id="destinatario" placeholder="Destinatario">,<label for="formato">Formato</label>
                            <select class="form-control" id="formato" name="formato">
                                <option value="Mail">Mail</option>
                                <option value="Pec">Pec</option>
                                <option value="Fax">Fax</option>
                                <option value="Documento">Documento</option>
                                <option value="Posta Ordinaria">Posta Ordinaria</option>
                                <option value="Raccomandata">Raccomandata</option>
                                <option value="Raccomandata AG">Raccomandata AG</option>
                                <option value="Raccomandata AR">Raccomandata AR</option>
                                <option value="Ufficiale Giudiziario">Ufficiale Giudiziario</option>
                            </select>,<label for="oggetto">Oggetto del documento</label>
                            <textarea class="form-control" name="oggetto" id="oggetto" placeholder="Oggetto del documento"></textarea>'
            ]);
    
            DB::table('formbuilder')->insert([
            'company'   => 'Medmar Navi SpA',
            'section'   => 'Sinistri',
            'formhtml'  => '<label for="utente">Utente</label>
                            <input type="text" class="form-control" name="utente" id="utente" placeholder="Nome dell\'utente">,<label for="evento">Data Evento</label>
                            <input type="date" class="form-control it-date-datepicker hasDatepicker" name="evento" id="evento" placeholder="inserisci la data in formato gg/mm/aaaa">,<label for="luogo">Luogo dell\'evento</label>
                            <select class="form-control" name="luogo" id="luogo">
                                <option value="Napoli">Napoli</option>
                                <option value="Ischia">Ischia</option>
                                <option value="Pozzuoli">Pozzuoli</option>
                                <option value="Casamicciola">Casamicciola</option>
                                <option value="Procida">Procida</option>
                                <option value="MN Benito Buono">MN Benito Buono</option>
                                <option value="MN Maria Buono">MN Maria Buono</option>
                                <option value="MN Medmar Giulia">MN Medmar Giulia</option>
                                <option value="MN Quirino">MN Quirino</option>
                                <option value="MN Rosa D\'Abundo">MN Rosa D\'Abundo</option>
                                <option value="MN Agata">MN Agata</option>
                                <option value="MN TFB I">MN TFB I</option>
                                <option value="MN TFB II">MN TFB II</option>
                                <option value="MN TFB III">MN TFB III</option>
                                <option value="MN Antonio Amabile">MN Antonio Amabile</option>
                                <option value="MN Lora D\'Abundo">MN Lora D\'Abundo</option>
                                <option value="MN Pasqualina Catania">MN Pasqualina Catania</option>
                                <option value="MN Emanuele D\'Abundo I">MN Emanuele D\'Abundo I</option>
                                <option value="MN Ischia">MN Ischia</option>
                                <option value="MN Redentore I">MN Redentore I</option>
                                <option value="MN Heidi">MN Heidi</option>
                                <option value="MN Ischia Express">MN Ischia Express</option>
                                <option value="MN Oceania">MN Oceania</option>
                            </select>,<label for="tipo">Tipologia sinistro</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <option value="Autovettura">Autovettura</option>
                                <option value="Autocarro">Autocarro</option>
                                <option value="Bus">Bus</option>
                                <option value="Moto">Moto</option>
                                <option value="Infortunio">Infortunio</option>
                            </select>,<label for="targa">Targa del veicolo</label>
                            <input type="text" class="form-control" name="targa" id="targa" placeholder="Targa del veicolo">,<label for="descrizione">Descrizione</label>
                            <textarea class="form-control" name="descrizione" id="descrizione" placeholder="Descrizione dell\'evento"></textarea>,<label for="valore">Valore controversia</label>
                            <input type="text" class="form-control" name="valore" id="valore" placeholder="Valore controversia">,<label for="foro">Foro Competenza</label>
                            <input type="text" class="form-control" name="foro" id="foro" placeholder="Foro Competenza">,<label for="studio_legale">Studio Legale</label>
                            <input type="text" class="form-control" name="studio_legale" id="studio_legale" placeholder="Studio Legale">,<label for="udienza">Data Udienza</label>
                            <input type="date" class="form-control it-date-datepicker hasDatepicker" id="udienza" placeholder="inserisci la data in formato gg/mm/aaaa" name="data">,<label for="status">Status</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" id="status_si">
                                <label for="status_si">Aperto</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" id="status_si">
                                <label for="status_si">Chiuso</label>
                            </div>,<label for="esito">Provvedimento/Transazione</label>
                            <input type="text" class="form-control" name="esito" id="esito" placeholder="Provvedimento/Transazione">,<label for="esito">Esito</label>
                            <select name="esito" class="form-control" id="esito">
                                <option value="">- - -</option>
                                <option value="Favorevole">Favorevole</option>
                                <option value="Parzialmente">Parzialmente</option>
                                <option value="Sfavorevole">Sfavorevole</option>
                                <option value="Senza Seguito">Senza Seguito</option>
                            </select>,<label for="archivio">Archivio</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="archivio" id="archivio_si">
                                <label for="archivio_si">Archiviato</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="archivio" id="archivio_no">
                                <label for="archivio_no">NON Archiviato</label>
                            </div>'
            ]);
    
            DB::table('formbuilder')->insert([
            'company'   => 'Medmar Navi SpA',
            'section'   => 'Legale',
            'formhtml'  => '<label for="utente">Utente</label>
                            <input type="text" class="form-control" name="utente" id="utente" placeholder="Nome dell\'utente">,<label for="evento">Data Evento</label>
                            <input type="date" class="form-control it-date-datepicker hasDatepicker" name="evento" id="evento" placeholder="inserisci la data in formato gg/mm/aaaa">,<label for="luogo">Luogo dell\'evento</label>
                            <select class="form-control" name="luogo" id="luogo">
                                <option value="Napoli">Napoli</option>
                                <option value="Ischia">Ischia</option>
                                <option value="Pozzuoli">Pozzuoli</option>
                                <option value="Casamicciola">Casamicciola</option>
                                <option value="Procida">Procida</option>
                                <option value="MN Benito Buono">MN Benito Buono</option>
                                <option value="MN Maria Buono">MN Maria Buono</option>
                                <option value="MN Medmar Giulia">MN Medmar Giulia</option>
                                <option value="MN Quirino">MN Quirino</option>
                                <option value="MN Rosa D\'Abundo">MN Rosa D\'Abundo</option>
                                <option value="MN Agata">MN Agata</option>
                                <option value="MN TFB I">MN TFB I</option>
                                <option value="MN TFB II">MN TFB II</option>
                                <option value="MN TFB III">MN TFB III</option>
                                <option value="MN Antonio Amabile">MN Antonio Amabile</option>
                                <option value="MN Lora D\'Abundo">MN Lora D\'Abundo</option>
                                <option value="MN Pasqualina Catania">MN Pasqualina Catania</option>
                                <option value="MN Emanuele D\'Abundo I">MN Emanuele D\'Abundo I</option>
                                <option value="MN Ischia">MN Ischia</option>
                                <option value="MN Redentore I">MN Redentore I</option>
                                <option value="MN Heidi">MN Heidi</option>
                                <option value="MN Ischia Express">MN Ischia Express</option>
                                <option value="MN Oceania">MN Oceania</option>
                            </select>,<label for="tipo">Tipologia sinistro</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <option value="Autovettura">Autovettura</option>
                                <option value="Autocarro">Autocarro</option>
                                <option value="Bus">Bus</option>
                                <option value="Moto">Moto</option>
                                <option value="Infortunio">Infortunio</option>
                            </select>,<label for="targa">Targa del veicolo</label>
                            <input type="text" class="form-control" name="targa" id="targa" placeholder="Targa del veicolo">,<label for="descrizione">Descrizione</label>
                            <textarea class="form-control" name="descrizione" id="descrizione" placeholder="Descrizione dell\'evento"></textarea>,<label for="valore">Valore controversia</label>
                            <input type="text" class="form-control" name="valore" id="valore" placeholder="Valore controversia">,<label for="foro">Foro Competenza</label>
                            <input type="text" class="form-control" name="foro" id="foro" placeholder="Foro Competenza">,<label for="studio_legale">Studio Legale</label>
                            <input type="text" class="form-control" name="studio_legale" id="studio_legale" placeholder="Studio Legale">,<label for="udienza">Data Udienza</label>
                            <input type="date" class="form-control it-date-datepicker hasDatepicker" id="udienza" placeholder="inserisci la data in formato gg/mm/aaaa" name="data">,<label for="status">Status</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" id="status_si">
                                <label for="status_si">Aperto</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" id="status_si">
                                <label for="status_si">Chiuso</label>
                            </div>,<label for="esito">Provvedimento/Transazione</label>
                            <input type="text" class="form-control" name="esito" id="esito" placeholder="Provvedimento/Transazione">,<label for="esito">Esito</label>
                            <select name="esito" class="form-control" id="esito">
                                <option value="">- - -</option>
                                <option value="Favorevole">Favorevole</option>
                                <option value="Parzialmente">Parzialmente</option>
                                <option value="Sfavorevole">Sfavorevole</option>
                                <option value="Senza Seguito">Senza Seguito</option>
                            </select>,<label for="archivio">Archivio</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="archivio" id="archivio_si">
                                <label for="archivio_si">Archiviato</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="archivio" id="archivio_no">
                                <label for="archivio_no">NON Archiviato</label>
                            </div>'
            ]);
    }
}
