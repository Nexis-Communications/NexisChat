<?= $this->extend('layout/layout') ?>
<?= $this->section('main') ?>
     
<div class="row">
	<div class="col-md-3">

		<!-- Tips Widget -->
		<!--===================================================-->
		<div class="mar-btm ">
			<h4 class="text-thin"><i class="fa fa-lightbulb-o fa-lg fa-fw text-warning bg-dark"></i> Useful tips</h4>
			<p class="text-muted mar-top">If you've visited chat rooms in the past, it's pretty similar. Choose a name and start chatting. </p>
			<div class="list-group bg-primary p-3">
				<p><span class="badge badge-secondary badge-pill">1</span> Intoduce yourself. Ask if anyone is into a similar topic. Lurking is ok. It's ok to just sit and see what other people are talking about.</p>
				<p><span class="badge badge-secondary badge-pill">2</span> Be Respectful. Not everyone has the same opinion and that's ok.</p>
				<p><span class="badge badge-secondary badge-pill">3</span> No Caps! Don't always talk in caps. People shoouldn't be shouting all the time.</p>
				<p><span class="badge badge-secondary badge-pill">4</span> Follow the Rules! Rules will be updated from time to time. There are site rules, room rules, and an admin may enforce rules at anytime. But always remember, You Rule!</p>
			</div>
		</div>
		<!--===================================================-->

		<hr>

		<!-- Contact us widget -->
		<!--===================================================-->
		<div class="mar-btm">
			<h4 class="text-thin"><i class="fa fa-question-circle fa-lg fa-fw text-primary"></i> Can't find the answer? </h4>
			<p class="text-muted mar-top">Send any support requests to us via our <a href="/contact">Contact Form</a> or email us at <a href="mailto:support@theparkchat.com">support@theparkchat.com</a> or <a href="mailto:info@theparkchat.com">info@theparkchat.com</a></p>
			<a href="/contact" class="btn btn-primary">Contact us</a>
		</div>
		<!--===================================================-->

	</div>
	<div class="col-md-9">
		<div class="panel">
			<div class="panel-body pb-3">


<?php //dd(getFaq()); ?>



<?php

if ($faqs = getFaq()) {
	//dd($faqs);
	if ($faqs->data->total > 0) {

		if (isset($faqs->data->categories)) {

			$iCat = 0;
			foreach ($faqs->data->categories as $category) {
				//print_r($category);
				?>
				<!-- <?= strtoupper($category->name) ?> -->
				<!--<?php for($i=0;$i<50;$i++){ ?>=<?php } ?>-->
				<h3><?= $category->name ?></h3>
				<p class="text-muted"><?= $category->description ?></p>
				<?php
				if ($category->faqs->total > 0) {
					?>
					
					<div class="panel-group accordion" id="<?= strtolower(preg_replace('/\s+/','',$category->name)) ?>-faq">
						<div class="card">
					<?php
					foreach ($category->faqs->faq as $faq) {
						?>

							<!-- Question -->
							<div class="card-header" id="head-<?= strtolower(preg_replace('/\s+/','',$category->name)) ?>-faq<?= $faq->id ?>">
								<h2 class="mb-0">
									<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#<?= strtolower(preg_replace('/\s+/','',$category->name)) ?>-faq<?= $faq->id ?>" aria-expanded="true" aria-controls="<?= strtolower(preg_replace('/\s+/','',$category->name)) ?>-faq<?= $faq->id ?>">
										<?= $faq->question ?>

									</button>
								</h2>
							</div>

							<!-- Answer -->
							<div id="<?= strtolower(preg_replace('/\s+/','',$category->name)) ?>-faq<?= $faq->id ?>" class="collapse" aria-labelledby="head-<?= strtolower(preg_replace('/\s+/','',$category->name)) ?>-faq<?= $faq->id ?>" data-parent="#<?= strtolower(preg_replace('/\s+/','',$category->name)) ?>-faq" >
								<div class="card card-body">
								<?= $faq->answer ?>

								</div>
							</div>
						
						<?php
					}

					
					?>

						</div> <!-- ./card -->
					<?php
				} 

				if ($category->children->count > 0) {
					?>
					<a class="btn btn-primary disabled mt-3" href="/support/faq/<?= strtolower(preg_replace('/\s+/','',$category->name)) ?>" role="button">View More</a>

					<?php
				}

				if (++$iCat < $faqs->data->total) {
				
				?>

						<hr class="bord-no pad-all">

				<?php
				
				}
			}
		}
	}	
}




?>


			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>
