<?php
  include 'admin/data.php';
  $data = load_processed_data("admin/");

  $progresses = get_progresses($data);

  function get_sub_epic_progress($a, $b) {
    global $progresses;
    echo($progresses["sub"]["val"][$a-1][$b-1]);
  }

  function get_epic_progress($a) {
    global $progresses;
    echo($progresses["epic"]["val"][$a-1]);
  }

  function get_sub_epic_progress_style($a, $b) {
    global $progresses;
    echo($progresses["sub"]["style"][$a-1][$b-1]);
  }

  function get_epic_progress_style($a) {
    global $progresses;
    echo($progresses["epic"]["style"][$a-1]);
  }

  function get_data($a, $b, $type, $number=0) {
    global $data;
    $field = $data[$a-1][$b-1][$type];
    if ($type == "progress") {
      $state = $field[$number -1];
      if ($state == 0) {
        echo('<div class="progress-state col-4"><p class="awaiting-start">Ootel (0%)</p></div>');
      } elseif ($state == 1) {
        echo('<div class="progress-state col-4"><p class="in-progress">Töö käib (0-50%)</p></div>');
      } elseif ($state == 2) {
        echo('<div class="progress-state col-4"><p class="almost-finished">Peaaegu valmis (50-75%)</p></div>');
      } elseif ($state == 3) {
        echo('<div class="progress-state col-4"><p class="finished">Tehtud (100%)</p></div>');
      } else {
        echo('<div class="progress-state col-4"><p class="awaiting-start">Andmed puuduvad (0%)</p></div>');
      }
    } else {
      echo ($field);
    }
  }

 ?>

<!DOCTYPE html>
<html lang="et">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" type="text/css">

	 <title>Avatud valitsemise partnerluse tegevuskava elluviimine</title>
  </head>
  <body>


	  <header id="intro">
		  <div class="container">
		  <h1>Avatud valitsemise partnerluse tegevuskava elluviimine</h1>
			  <div><p> Andmeid viimati uuendatud: <?php echo(get_timestamp("admin/")); ?></p></div>
			  <p><b>Kliki eesmärgi pealkirjal, et näha rohkem infot.</b></p>
			  </div>
	  </header>     <!-- Header section -->

	  <section id="progress">

	  <div class="container" id="main_container">
			<div class="goal-head" width="100%">  <!-- Goal 1 head -->
				<a class="btn" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">
					<div class="row">

						<div class="col-md-7">
							<div class="text-left">
								<h2>1. Kaasamise ja läbipaistvuse suurendamine poliitikakujundamisel</h2>
							</div>
						</div>


						  <div class="col-md-5 progress-bar-container">

							  <div class="row">

							  <div class="col-2 text-center progress-bar-label">
											<p>0%</p>
								</div>

							<div class="progress col-8">
								<div class="progress-bar <?php get_epic_progress_style(1); ?>" role="progressbar" style="width: <?php get_epic_progress(1); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>

								<div class="col-2 text-center progress-bar-label">
											<p>100%</p>
								</div>
								  </div>
						  </div>



						</div> <!--ROW-->
					</a>
				</div> <!-- Goal 1 head ends -->


				<div class="collapse" id="collapse1"> <!-- Goal 1 collapse -->

  					<div class="card card-body card1">

						<div class="subgoal-head" width="100%"> <!-- Goal 1-1 head -->

								<a class="btn" data-toggle="collapse" href="#collapse1-1" role="button" aria-expanded="false" aria-controls="collapse1-1">
										<div class="row">

										<div class="col-md-8 text-left">
											<h3>1.1. Läbipaistvat ja kaasavat poliitikakujundamist toetav infotehnoloogia</h3>
										</div>

									  <div class="col-md-4 progress-bar-container">
										<div class="progress">
											<div class="progress-bar <?php get_sub_epic_progress_style(1, 1); ?>" role="progressbar" style="width: <?php get_sub_epic_progress(1, 1); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									  </div>

									</div> <!--ROW-->
								</a>
						</div> <!-- Goal 1-1 head -->

						<div class="collapse" id="collapse1-1"> <!-- Goal 1-1 collapse -->

								 <div class="card card-body card2">
									<h4>Seisukord</h4>

									<div class="row">
										<div class="col-8">
											<p>1.1. Vajaduste ning praeguse olukorra väljaselgitamine, sh kogemuse analüüs:</p>
										</div>
										<?php get_data(1,1,"progress",1);?>
									</div>

									<div class="row">
										<div class="col-8">
											<p>1.1 Alternatiivide kaalumine ning keskkonna funktsioonide ja liidestuste kirjeldamine:</p>
										</div>
										<?php get_data(1,1,"progress",2);?>
									</div>

									<div class="row">
										<div class="col-8">
											<p>1.1. Lähteülesande koostamine, sh infosüsteemi nõuete kirjeldamine:</p>
										</div>
										<?php get_data(1,1,"progress",3);?>
									</div>

									<h4>Vastutaja</h4>

									<p>Riigikantselei</p>

									<h4>Kaasvastutajad</h4>

									<p><b>Osalevad asutused:</b> kõik ministeeriumid, põhiseaduslikud institutsioonid ja omavalitsusüksuste üleriigilised liidud</p>

									<p><b>Valitsusvälised organisatsioonid:</b> Vabaühenduste Liit, Eesti Koostöö Kogu, E-riigi Akadeemia jt</p>

									<h4>Põhjendused ja selgitused</h4>

									<p><?php get_data(1,1,"reasoning",4);?></p>

									<h4>Lingid materjalidele</h4>

									<p><?php get_data(1,1,"links",5);?></p>
							</div>
						</div> <!-- Goal 1-1 collapse -->


						<div class="subgoal-head" width="100%"> <!-- Goal 1-2 head -->

								<a class="btn" data-toggle="collapse" href="#collapse1-2" role="button" aria-expanded="false" aria-controls="collapse1-2">
										<div class="row">

										<div class="col-md-8 text-left">
											<h3>1.2. Kaasava, teadmistepõhise ja kodanikukeskse poliitikakujundamise protsessi kujundamine ja oskuste arendamine</h3>
										</div>

									  <div class="col-md-4 progress-bar-container">
										<div class="progress">
											<div class="progress-bar <?php get_sub_epic_progress_style(1, 2); ?>" role="progressbar" style="width: <?php get_sub_epic_progress(1, 2); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									  </div>

									</div> <!--ROW-->
								</a>
							</div> <!-- Goal 1-2 head ends-->


							<div class="collapse" id="collapse1-2"> <!-- Goal 1-2 collapse -->
  									<div class="card card-body card2">
									<h4>Seisukord</h4>

									<div class="row">
										<div class="col-8">
											<p>1.2 Kaasamise koordinaatorite võrgustiku töökorraldus on üle vaadatud ning võrgustik tegutseb aktiivselt:</p>
										</div>
										<?php get_data(1,2,"progress",1);?>
									</div>

									<div class="row">
										<div class="col-8">
											<p>1.2 Välja on kuulutatud hange avaliku teenistuse tippjuhtide poliitikakujundamise koolitusprogrammi elluviimiseks:</p>
										</div>
										<?php get_data(1,2,"progress",2);?>
									</div>

									<div class="row">
										<div class="col-8">
											<p>1.2 Koolitatud on 100 riigi- või kohaliku omavalitsuse ametnikku ja vabaühenduse esindajat. Esimeste koolitusrühmade tagasiside põhjal on programm üle vaadatud ja täiendatud:</p>
										</div>
										<?php get_data(1,2,"progress",3);?>
									</div>

									<div class="row">
										<div class="col-8">
											<p>1.2 Võrgustik tegutseb aktiivselt:</p>
										</div>
										<?php get_data(1,2,"progress",4);?>
									</div>

									<div class="row">
										<div class="col-8">
											<p>1.2 Tippjuhid koolitatud:</p>
										</div>
										<?php get_data(1,2,"progress",5);?>
									</div>

									<div class="row">
										<div class="col-8">
											<p>1.2 Ametnikud koolitatud:</p>
										</div>
										<?php get_data(1,2,"progress",6);?>
									</div>

									<h4>Vastutaja</h4>

									<p>Riigikantselei</p>

									<h4>Kaasvastutajad</h4>

									<p><b>Osalevad asutused:</b> Rahandusministeerium, Riigi Tugiteenuste Keskus, kõik ministeeriumid</p>

									<p><b>Valitsusvälised organisatsioonid:</b> Praxis, Centar, Velvet, Vabaühenduste Liit</p>

									<h4>Põhjendused ja selgitused</h4>

									<p><?php get_data(1,2,"reasoning",6);?></p>

									<h4>Lingid materjalidele</h4>

									<p><?php get_data(1,2,"links",6);?></p>
							</div>
						</div> <!-- Goal 1-2 collapse ends -->

							<div class="subgoal-head" width="100%"> <!-- Goal 1-3 head -->

								<a class="btn" data-toggle="collapse" href="#collapse1-3" role="button" aria-expanded="false" aria-controls="collapse1-3">
										<div class="row">

										<div class="col-md-8 text-left">
											<h3>1.3. Riigikogu tegevuse avatuse ja läbipaistvuse suurendamine</h3>
										</div>

									  <div class="col-md-4 progress-bar-container">
										<div class="progress">
										   <div class="progress-bar <?php get_sub_epic_progress_style(1, 3); ?>" role="progressbar" style="width: <?php get_sub_epic_progress(1, 3); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									  </div>

									</div> <!--ROW-->
								</a>
							</div> <!-- Goal 1-3 head ends-->

							<div class="collapse" id="collapse1-3"> <!-- Goal 1-3 collapse -->
  									<div class="card card-body card2">
									<h4>Seisukord</h4>

									<div class="row">
										<div class="col-8">
											<p>1.3 Riigikogu avaandmed on testkasutuses:</p>
										</div>
										<?php get_data(1,3,"progress",1);?>
									</div>

									<div class="row">
										<div class="col-8">
											<p>1.3 Riigikogu avaandmed on püsivalt kättesaadavad:</p>
										</div>
										<?php get_data(1,3,"progress",2);?>
									</div>

                  <div class="row">
										<div class="col-8">
											<p>1.3 Protokollid avaldatakse esimesel võimalusel:</p>
										</div>
										<?php get_data(1,3,"progress",3);?>
									</div>

									<h4>Vastutaja</h4>

									<p>Riigikogu</p>

									<h4>Kaasvastutajad</h4>

									<p><b>Valitsusvälised organisatsioonid:</b> Eesti Koostöö Kogu, Vabaühenduste Liit</p>

									<h4>Põhjendused ja selgitused</h4>

									<p><?php get_data(1,3,"reasoning",6);?></p>

									<h4>Lingid materjalidele</h4>

                  <p><?php get_data(1,3,"links",6);?></p>
							</div>

  					</div>  <!-- Goal 1-3 collapse ends-->

				</div>

				</div> <!-- Goal 1 collapse ends -->

		  	<div class="goal-head" width="100%">  <!-- Goal 2 head -->
				<a class="btn" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">
					<div class="row">

						<div class="col-md-7">
							<div class="text-left">
								<h2>2. Kaasamise ja läbipaistvuse suurendamine kohalikus omavalitsuses</h2>
							</div>
						</div>

						  <div class="col-md-5 progress-bar-container">


							  <div class="row">
							  <div class="col-2 text-center progress-bar-label">
											<p>0%</p>
								</div>

							<div class="progress col-8">
								<div class="progress-bar <?php get_epic_progress_style(2); ?>" role="progressbar" style="width: <?php get_epic_progress(2); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>

								 <div class="col-2 text-center progress-bar-label">
											<p>100%</p>
								</div>
							  </div>

						  </div>

						</div> <!--ROW-->
					</a>
				</div> <!-- Goal 2 head ends-->


				<div class="collapse" id="collapse2"> <!-- Goal 2 collapse -->

  					<div class="card card-body card1">

						<div class="subgoal-head" width="100%"> <!-- Goal 2-1 head -->

								<a class="btn" data-toggle="collapse" href="#collapse2-1" role="button" aria-expanded="false" aria-controls="collapse2-1">
										<div class="row">

										<div class="col-md-8 text-left">
											<h3>2.1. Avatud valitsemise tegevuskava väljatöötamine ja tegevuste juurutamine kohalikus omavalitsuses</h3>
										</div>

									  <div class="col-md-4 progress-bar-container">
										<div class="progress">
											<div class="progress-bar <?php get_sub_epic_progress_style(2, 1); ?>" role="progressbar" style="width: <?php get_sub_epic_progress(2, 1); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									  </div>

									</div> <!--ROW-->
								</a>
						</div> <!-- Goal 2-1 head ends-->

						<div class="collapse" id="collapse2-1"> <!-- Goal 2-1 collapse -->
								 <div class="card card-body card2">
									<h4>Seisukord</h4>

									<div class="row">
										<div class="col-8">
											<p>2.1 Taotlusvooru tingimuste läbirääkimine huvirühmadega:</p>
										</div>
										<?php get_data(2,1,"progress",1);?>
									</div>

									<div class="row">
										<div class="col-8">
											<p>2.1 Taotlusvooru väljakuulutamine:</p>
										</div>
										<?php get_data(2,1,"progress",2);?>
									</div>

                  					<div class="row">
										<div class="col-8">
											<p>2.1 5 KOV-is avatud valitsemise tegevuskava välja töötatud:</p>
										</div>
										<?php get_data(2,1,"progress",3);?>
									</div>

									<h4>Vastutaja</h4>

									<p>Rahandusministeerium</p>

									<h4>Kaasvastutajad</h4>

									<p><b>Osalevad asutused:</b> Vallad ja linnad</p>

									<p><b>Valitsusvälised organisatsioonid:</b> Eesti Linnade ja Valdade Liit, E-riigi Akadeemia</p>

									 <h4>Põhjendused ja selgitused</h4>

									 <p><?php get_data(2,1,"reasoning",6);?></p>

									 <h4>Lingid materjalidele</h4>

									 <p><?php get_data(2,1,"links",6);?></p>
									</div>
						</div>  <!-- Goal 2-1 collapse -->


						<div class="subgoal-head" width="100%"> <!-- Goal 2-2 head -->

								<a class="btn" data-toggle="collapse" href="#collapse2-2" role="button" aria-expanded="false" aria-controls="collapse2-2">
										<div class="row">

										<div class="col-md-8 text-left">
											<h3>2.2 Kohalike avalike teenuste tasemete analüüsi tulemuste lihtne ja kasutajasõbralik esitamine</h3>
										</div>

									  <div class="col-md-4 progress-bar-container">
										<div class="progress">
											<div class="progress-bar <?php get_sub_epic_progress_style(2, 2); ?>" role="progressbar" style="width: <?php get_sub_epic_progress(2, 2); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									  </div>

									</div> <!--ROW-->
								</a>
							</div> <!-- Goal 2-2 head ends-->


							<div class="collapse" id="collapse2-2"> <!-- Goal 2-2 collapse -->
  									<div class="card card-body card2">
									<h4>Seisukord</h4>

									<div class="row">
										<div class="col-8">
											<p>2.2 Esitlusviisi prototüübi koostamine koostöös partneritega:</p>
										</div>
										<?php get_data(2,2,"progress",1);?>
									</div>

									<div class="row">
										<div class="col-8">
											<p>2.2 Arenduse lähteülesande koostamine koostöös partneritega:</p>
										</div>
										<?php get_data(2,2,"progress",2);?>
									</div>

									  <div class="row">
										<div class="col-8">
										  <p>2.2 Arendus valmis:</p>
										</div>
										<?php get_data(2,2,"progress",3);?>
									  </div>

                  					<div class="row">
										<div class="col-8">
											<p>2.2 Kasutuse propageerimine:</p>
										</div>
										<?php get_data(2,2,"progress",4);?>
									</div>

									<h4>Vastutaja</h4>

									<p>Rahandusministeerium</p>

									<h4>Kaasvastutajad</h4>

									<p><b>Osalevad asutused:</b> Riigikantselei</p>

									<p><b>Valitsusvälised organisatsioonid:</b> Eesti Linnade ja Valdade Liit, Koostöökogu</p>

								  <h4>Põhjendused ja selgitused</h4>

								  <p><?php get_data(2,2,"reasoning",6);?></p>

								  <h4>Lingid materjalidele</h4>

								  <p><?php get_data(2,2,"links",6);?></p>
							  </div>
						</div> <!-- Goal 2-2 collapse ends-->

					</div>

				</div> <!-- Goal 2 collapse ends-->

		  		<div class="goal-head" width="100%">  <!-- Goal 3 head -->
				<a class="btn" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">
					<div class="row">

						<div class="col-md-7">
							<div class="text-left">
								<h2>3. Osalusdemokraatia hoiakute ja oskuste arendamine üldhariduses</h2>
							</div>
						</div>

						  <div class="col-md-5 progress-bar-container">

							  <div class="row">
							  <div class="col-2 text-center progress-bar-label">
											<p>0%</p>
								</div>

							<div class="progress col-8">
								<div class="progress-bar <?php get_epic_progress_style(3); ?>" role="progressbar" style="width: <?php get_epic_progress(3); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>

							  <div class="col-2 text-center progress-bar-label">
									<p>100%</p>
								</div>
								  </div>
						  </div>

						</div> <!--ROW-->
					</a>
				</div> <!-- Goal 3 head ends-->


				<div class="collapse" id="collapse3"> <!-- Goal 3 collapse -->

  					<div class="card card-body card1">

						<div class="subgoal-head" width="100%"> <!-- Goal 3-1 head -->

								<a class="btn" data-toggle="collapse" href="#collapse3-1" role="button" aria-expanded="false" aria-controls="collapse3-1">
										<div class="row">

										<div class="col-md-8 text-left">
											<h3>3.1. Osalusdemokraatia hoiakute ja oskuste arendamine üldhariduses</h3>
										</div>

									  <div class="col-md-4 progress-bar-container">
										<div class="progress">
											<div class="progress-bar <?php get_sub_epic_progress_style(3, 1); ?>" role="progressbar" style="width: <?php get_sub_epic_progress(3, 1); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									  </div>

									</div> <!--ROW-->
								</a>
						</div> <!-- Goal 3-1 head ends-->

						<div class="collapse" id="collapse3-1"> <!-- Goal 3-1 collapse -->
								 <div class="card card-body card2">
									<h4>Seisukord</h4>

									<div class="row">
										<div class="col-8">
											<p>3.1 Ainevaldkonna töörühm koostab ja esitab esmased ettepanekud uuendatud õpitulemuste kohta:</p>
										</div>
										<?php get_data(3,1,"progress",1);?>
									</div>

									  <div class="row">
										<div class="col-8">
										  <p>3.1 Konsultatsioonid huvirühmadega:</p>
										</div>
										<?php get_data(3,1,"progress",2);?>
									  </div>

									<h4>Vastutaja</h4>

									<p>Haridus- ja Teadusministeerium</p>

									<h4>Kaasvastutajad</h4>

									<p><b>Osalevad asutused:</b> Sihtasutus Innove</p>

									<p><b>Valitsusvälised organisatsioonid:</b> Huvitatud vabaühendused, Tallinna Ülikool, Tartu Ülikool, Eesti Ajaloo- ja Ühiskonnaõpetajate Selts, Inimeseõpetuse Ühing, maakondlikud ainesektsioonid, Eesti Õpilasesinduste Liit, kirjastused jt</p>

									  <h4>Põhjendused ja selgitused</h4>

									  <p><?php get_data(3,1,"reasoning",6);?></p>

									  <h4>Lingid materjalidele</h4>

									  <p><?php get_data(3,1,"links",6);?></p>
                			</div>
						</div> <!-- Goal 3-1 collapse ends-->

					</div>

				</div> <!-- Goal 3 collapse ends-->

		  </div>
		</section>





    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.3.1.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
