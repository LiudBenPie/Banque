<h1>Créer un Nouveau RDV</h1>
<form action="/sauvegarderRdv.php" method="post">
    <div>
        <label for="dateRdv">Date du RDV:</label>
        <input type="date" id="dateRdv" name="dateRdv" required>
    </div>
    <div>
        <label for="timeRdv">Heure du RDV (en heures):</label>
        <input type="number" id="timeRdv" name="timeRdv" min="0" max="23" required>
    </div>
    <div>
        <label for="idMotif">Motif du RDV:</label>
        <select id="idMotif" name="idMotif" required>
            <option value="">Sélectionner un motif</option>
            <!-- Les options seront générées dynamiquement dans le script PHP -->
        </select>
    </div>
    <button type="submit">Planifier RDV</button>
</form>