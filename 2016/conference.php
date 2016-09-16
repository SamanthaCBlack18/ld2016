<?php
# Linux Day 2016 - Single conference page
# Copyright (C) 2016 Valerio Bozzolan, Ludovico Pavesi
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

require 'load.php';

$conference = null;
if( ! empty( $_GET['uid'] ) ) {
	$conference = Conference::getConference(
		luser_input( $_GET['uid'], 64 )
	);
}

$conference
	|| die_with_404();

enqueue_css('animation');

new Header('conference', [
	'show-title' => false,
	'head-title' => $s = $conference->getConferenceTitle(),
	'title'      => $s,
	'url'        => $conference->getConferenceURL()
] );
?>
	<div class="header">
		<center>
			<h1><?php echo HTML::a(
				$conference->getConferenceURL(),
				strtoupper( SITE_NAME )
			) ?></h1>

			<p class="flow-text"><?php echo str_replace(
				['/', 'GNU', 'Linux'], [
					'<b>/</b>',
					HTML::a(
						_('https://it.wikipedia.org/wiki/GNU'),
						'GNU',
						null,
						'black-text hoverable'
					),
					HTML::a(
						_('https://it.wikipedia.org/wiki/Linux_%28kernel%29'),
						'Linux',
						null,
						'black-text hoverable'
					)
				],
				SITE_DESCRIPTION
			) ?></p>
		</center>
	</div>

	<div class="section">
		<div class="row">
			<p class="flow-text"><?php printf(
				_(
					"Il Linux Day è la principale manifestazione italiana di promozione di tecnologia sostenibile. ".
					"Quest'anno a Torino si terrà nel <strong>%s</strong> dell'%s, di <strong>sabato</strong>, il %s."
				),
				_("Dipartimento di Informatica"),
				_("Università degli studi di Torino"),
				_("sabato"),
				_("22 ottobre 2016")
			) ?></p>
			<div class="col s12 m8">
				<blockquote class="flow-text">
					// How to write good code<br />
					<strong>$software</strong>: 
					function(<span class="yellow">play</span>, 
					<span class="blue lighten-3">freedom</span>, 
					<span class="orange">friends</span>) { }
				</blockquote>
			</div>
			<div class="col s12 m4">
				<p class="flow-text"><?php _e("Il tema di quest'anno a livello nazionale è... il <code>coding</code>!") ?></p>
			</div>
		</div>
	</div>

	<div id="where" class="divider"></div>
	<div class="section">
		<h3><?php _e("Come arrivare") ?></h3>
		<div class="row">
			<div class="col s12 m4">
				<p class="flow-text"><?php echo $conference->getLocationName() ?></p>
				<p><?php printf(
					_("%s, %s"),
					$conference->getLocationAddress(),
					$conference->getLocationNote()
				) ?></p>
			</div>
			<div class="col s12 m8">
				<div class="card hoverable">
					<div class="card-image">
						<img src="<?php echo $conference->getLocationGeothumb() ?>" alt="<?php _esc_html( $conference->getLocationName() ) ?>">
				        </div>
					<div class="card-content">
						<p></p>
					</div>
					<div class="card-action">
						<?php echo HTML::a(
							$conference->getLocationGeoOSM(),
							_("Vedi su OpenStreetMap"),
							sprintf(
								_("Vedi %s su OpenStreetMap"),
								esc_html( $conference->getConferenceTitle() )
							),
							'btn',
							'target="_blank"'
						) ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="talk" class="divider"></div>
	<div class="section">
		<?php $eventsTable = $conference->getDailyEventsTable() ?>

		<h3><?php _e("Talk") ?></h3>
		<p class="flow-text"><?php printf(
			_(
				"Un ampio programma fatto di %s talks di un'ora ciascuno distribuiti in %s ore, ".
				"affrontando tematiche riguardanti il software libero su più livelli, ".
				"per soddisfare le esigenze di un ampio pubblico (dai più piccoli, al curioso, fino agli esperti)."
			),
			"<b>{$eventsTable->countEvents()}</b>",
			"<b>{$eventsTable->getHours()}</b>"
		) ?></p>
		<p><?php printf(
			_("In seguito si riporta la tabella dei talk suddivisa in %s categorie:"),
			"<b>{$eventsTable->countTracks()}</b>"
		) ?></p>

		<?php $eventsTable->printTable(); ?>

		<p><?php _e("La tabella potrebbe subire variazioni.") ?></p>
	</div>

	<div id="play" class="divider"></div>
	<div class="section">
		<h3><?php _e("Attività") ?></h3>
		<p class="flow-text"><?php _e("In contemporanea ai talk avranno luogo diverse attività:") ?></p>
		<div class="row">
			<?php $box = function($what, $who, $url = null, $prep = null) {
				if( $url ) {
					$who = HTML::a($url, $who, null);
				} ?>

			<div class="col s12 m6 l4">
				<div class="card-panel hoverable">
					<p><span class="flow-text"><?php echo $what ?></span><br /> <?php printf( _("Gestito %s %s."), _("da"), $who ) ?></p>
				</div>
			</div>

			<?php };

			$box(
				_("Riparazione di apparecchiature elettroniche."),
				_("Associazione Tesso"),
				'http://www.associazionetesso.org'
			);
			$box(
				_("Laboratorio di coding per i più piccoli a tema Linux Day."),
				_("CoderDojo Torino"),
				'https://coderdojo.com'
			);
			$box(
				_("Allestimento museale di Retrocomputing."),
				"MUPIN",
				'http://mupin.it'
			);
			$box(
				_("LIP (Linux Installation Party) e assistenza tecnica distribuzioni GNU/Linux."),
				_("volontari")
			);
			?>

		</div>
	</div>
<?php new Footer();
