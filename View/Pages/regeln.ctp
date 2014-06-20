<div class="mainnav">
  <?php 
    echo $this->Session->flash('flash', array('element' => 'message'));
    echo $this->Session->flash('auth', array('element' => 'message'));
  ?>
</div> <!-- /.mainnav -->
<div class="content">
  <div class="container">
    <div class="row">
    <!-- start: Main Menu -->
    <?php echo $this->element('menu', array("active" => "matches")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">

          <h2 class="">Tippspielregeln</h2>

          <br>
          <h4 class="content-title"><u>Punkte pro Spiel</u></h4>
          <p>Diese Punkte werden pro Spiel vergeben und errechnen sich wie folgt:</p>
          <ol>
            <li>Komplett richtiges Ergebnis: <strong>30 Punkte</strong></li>
            <li>Richtige Tendenz: <strong>12 Punkte</strong></li>
            <li>Differenz des Ergebnisses:
              <ul class="list-unstyled">
                <li><em>Beispiel: tatsächliches Ergebnis: 2:1 bedeutet eine Differenz von 1.
Tip: 3:1 bedeutet eine Differenz von 2. Zusammen: Differenz zwischen Realität und Tip: 1, macht also 4 Extrapunkte zu den 12 wegen der richtigen Tendenz.</em>
                </li>
                <li>
                  Die Verteilung:
                    <ul class="list-inline">
                      <li>+/- 0 = <strong>8 Punkte</strong></li>
                      <li>+/- 1 = <strong>4 Punkte</strong></li>
                      <li>+/- 2 = <strong>2 Punkte</strong></li>
                      <li>+/- 3 = <strong>1 Punkte</strong></li>
                    </ul>
                </li>
              </ul>
            </li>
            <li>Differenz zu den erzielten Toren je Mannschaft:
              <ul class="list-unstyled">
                <li><em>Erst jede Seite einzeln vergleichen, dann beide Differenzen addieren und die Punkte zuordnen. <br>Beispiel: tatsächliches Ergebnis: 2:1, Tip: 3:1. Daraus ergibt sich:
                  <ul class="list-unstyled">
                    <li>3:1</li>
                    <li>2:1</li>
                    <li>1+0 = 1 bedeutet 4 Punkte.</li>
                  </ul></em>
                </li>
                <li>
                  Die Verteilung:
                  <ul class="list-inline">
                    <li>+/- 1 = <strong>4 Punkte</strong></li>
                    <li>+/- 2 = <strong>2 Punkte</strong></li>
                    <li>+/- 3 = <strong>1 Punkte</strong></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li>Zusätze wie "nach Elferschießen" etc. gibt es nicht. Wer meint, es gibt (ab den Achtelfinals) Elferschießen, der muss halt z.B. 11:10 tippen. Gezählt wird das Ergebnis nach 120 gespielten Minuten, die Elfertore werden auf dieses Ergebnis aufaddiert.
              <ul class="list-unstyled"><li><em>Spiel endet nach 120 Minuten 2:2, im Elferschießen trifft Mannschaft A 5mal, Mannschaft B 4mal. Das Ergebnis lautet dann: 7:6, und nur wer das getippt hat, bekommt die 30 Punkte</em></li>
              </ul></li>
          </ol>
          <h4 class="content-title"><u>Bonuspunkte für Gruppentabellen</u></h4>
          <p>Aus Euren Tips ergeben sich Tabellen für die einzelnen Vorrundengruppen. Diese werden mit den tatsächlichen Endtabellen verglichen. Dabei können nach Ende der Vorrunde Bonuspunkte eingefahren werden</p>
          <ol>
            <li>Für einen richtig getippten Tabellenplatz gibt es <strong>4 Punkte</strong></li>
            <li>Für richtig getippte Punkte einer Mannschaft werden Euch nochmal <strong>2 Punkte</strong> gutgeschrieben</li>
            <li>Für richtig getipptes Torverhältnis gibt es <strong>1 Punkt</strong></li>
          </ol>
          <h4 class="content-title"><u>Bonusfragen</u></h4>
          <ol>
            <li>Vorab richtig getippter Weltmeister: <strong>50 Bonuspunkte</strong> am Ende</li>
            <li>Vorab richtig getippte Nation des Torschützenkönigs: <strong>40 Bonuspunkte</strong> am Ende</li>
          </ol>

      </div>
    </div>
  </div>
</div>