<!-- Contact -->
<section class="page-section" id="contact">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h2 class="section-heading text-uppercase">Contact Us</h2>
				<h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<form action="/send" id="contactForm" name="sentMessage" novalidate="novalidate" method="post">
					@csrf
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input name="name" class="form-control" id="name" type="text" placeholder="Your Name *" required="required" data-validation-required-message="Please enter your name.">
								<p class="help-block text-danger"></p>
							</div>
							<div class="form-group">
								<input name="email" class="form-control" id="email" type="email" placeholder="Your Email *" required="required" data-validation-required-message="Please enter your email address.">
								<p class="help-block text-danger"></p>
							</div>
							<div class="form-group">
								<input name="phone" class="form-control" id="phone" type="tel" placeholder="Your Phone *" required="required" data-validation-required-message="Please enter your phone number.">
								<p class="help-block text-danger"></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<textarea name="message" class="form-control" id="message" placeholder="Your Message *" required="required" data-validation-required-message="Please enter a message."></textarea>
								<p class="help-block text-danger"></p>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-lg-12 text-center">
							@if(session('success'))
								<div class="alert alert-success alert-dismissible fade show" role="alert">
									{{session('success')}}
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							@endif

							@if(session('error') || $errors->any())
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									{{session('error')}}

									<ul style="padding-bottom: 0">
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>

									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							@endif
							<button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Send Message</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

@section('foot')
	@if(session('error') || $errors->any())
	<script>
		window.location.href = "#contact";
	</script>
	@endif
@endsection
