<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<section class="main-section">
	<div class="container-fluid mainWrapper listingMain buying_page">
		<div class="row">
			<!-- Start Copy From here  -->
			<div class="col-md-8 col-lg-9">
				<h1 class="leads-main-title">Browse marketplace categories (Worldwide Buying Leads) </h1>

				<div class="row">
					<div class="col-md-12">

						<?php if (! empty($buying_leads)): ?>
							<?php foreach ($buying_leads as $buying_lead):
                                ?>

								<div class="box-leads item-p-<?php echo $buying_lead['parent_data']->cat_id; ?>">
									<h2><?php echo ucwords($buying_lead['parent_data']->cat_name); ?></h2>

									<?php if (isset($buying_lead['child_data']) && ! empty($buying_lead['child_data'])) : ?>
									<ul>
										<?php foreach ($buying_lead['child_data'] as $lead_child):
											$slug = is_null($lead_child->slug) ? '#' : $lead_child->slug;
											$countr_code = isset($cc) ? '?cc=' . $cc : '';
										?>
											<li class="child-lead lead-<?php echo $lead_child->cat_id; ?>">
												<a href="<?php echo base_url('buying-lead/' . $slug . $countr_code); ?>"><?php echo ucwords($lead_child->cat_name); ?></a>
											</li>
										<?php endforeach; ?>
									</ul>
									<?php endif; ?>
								</div>

							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>


			<!-- Search -->
            <!-- right side-bar search start -->
            <?php include_once realpath(__DIR__ . '/..') . '/includes/sidebar_filter_listing.php'; ?>
            <!-- right side-bar search end -->
		</div>


		<!-- Start Flages Copy From here  -->
		<div class="row">

			<div class="col-md-12">
				<!-- Flags Html Start here -->
				<div class="box-leads bx_flg">
					<h2>Browse marketplace by Countries</h2>
					<div class="buying-leads">

						<ul class="home_countr" style="text-align: left;">


							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Afghanistan') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/af.svg'); ?>" alt="AF">
									<span>Afghanistan</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Albania') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/al.svg'); ?>" alt="AL">
									<span>Albania</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Algeria') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/dz.svg'); ?>" alt="DZ">
									<span>Algeria</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Angola') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ao.svg'); ?>" alt="AO">
									<span>Angola</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Anguilla') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ai.svg'); ?>" alt="AI">
									<span>Anguilla</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Argentina') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ar.svg'); ?>" alt="AR">
									<span>Argentina</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Australia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/au.svg'); ?>" alt="AU">
									<span>Australia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Azerbaijan') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/az.svg'); ?>" alt="AZ">
									<span>Azerbaijan</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Bahamas') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/bs.svg'); ?>" alt="BS">
									<span>Bahamas</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Bahrain') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/bh.svg'); ?>" alt="BH">
									<span>Bahrain</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Bangladesh') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/bd.svg'); ?>" alt="BD">
									<span>Bangladesh</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Barbados') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/bb.svg'); ?>" alt="BB">
									<span>Barbados</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Belarus') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/by.svg'); ?>" alt="BY">
									<span>Belarus</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Belgium') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/be.svg'); ?>" alt="BE">
									<span>Belgium</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Belize') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/bz.svg'); ?>" alt="BZ">
									<span>Belize</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Benin') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/bj.svg'); ?>" alt="BJ">
									<span>Benin</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Bhutan') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/bt.svg'); ?>" alt="BT">
									<span>Bhutan</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Botswana') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/bw.svg'); ?>" alt="BW">
									<span>Botswana</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Brazil') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/br.svg'); ?>" alt="BR">
									<span>Brazil</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('British Indian') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/io.svg'); ?>" alt="IO">
									<span>British Indian</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Bulgaria') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/bg.svg'); ?>" alt="BG">
									<span>Bulgaria</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Burkina Faso') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/bf.svg'); ?>" alt="BF">
									<span>Burkina Faso</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Cambodia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/kh.svg'); ?>" alt="KH">
									<span>Cambodia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Cameroon') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/cm.svg'); ?>" alt="CM">
									<span>Cameroon</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Canada') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ca.svg'); ?>" alt="CA">
									<span>Canada</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Chile') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/cl.svg'); ?>" alt="CL">
									<span>Chile</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('China') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/cn.svg'); ?>" alt="CN">
									<span>China</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Colombia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/co.svg'); ?>" alt="CO">
									<span>Colombia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Congo') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/cg.svg'); ?>" alt="CG">
									<span>Congo</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message("Cote D'Ivoire") ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ci.svg'); ?>" alt="CI">
									<span>Cote D'Ivoire</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Croatia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/hr.svg'); ?>" alt="HR">
									<span>Croatia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Cyprus') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/cy.svg'); ?>" alt="CY">
									<span>Cyprus</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Ecuador') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ec.svg'); ?>" alt="EC">
									<span>Ecuador</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Egypt') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/eg.svg'); ?>" alt="EG">
									<span>Egypt</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Eritrea') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/er.svg'); ?>" alt="ER">
									<span>Eritrea</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Ethiopia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/et.svg'); ?>" alt="ET">
									<span>Ethiopia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Faroe Islands') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/fo.svg'); ?>" alt="FO">
									<span>Faroe Islands</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Fiji') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/fj.svg'); ?>" alt="FJ">
									<span>Fiji</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('France') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/fr.svg'); ?>" alt="FR">
									<span>France</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Georgia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ge.svg'); ?>" alt="GE">
									<span>Georgia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Germany') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/de.svg'); ?>" alt="DE">
									<span>Germany</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Ghana') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/gh.svg'); ?>" alt="GH">
									<span>Ghana</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Gibraltar') ); ?>" >


									<img src="<?php echo base_url('assets/images/country-flags/gi.svg'); ?>" alt="GI">
									<span>Gibraltar</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Greece') ); ?>" >


									<img src="<?php echo base_url('assets/images/country-flags/gr.svg'); ?>" alt="GR">
									<span>Greece</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Guadeloupe') ); ?>" >


									<img src="<?php echo base_url('assets/images/country-flags/gp.svg'); ?>" alt="GP">
									<span>Guadeloupe</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Guinea') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/gn.svg'); ?>" alt="GN">
									<span>Guinea</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Guyana') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/gy.svg'); ?>" alt="GY">
									<span>Guyana</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Haiti') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ht.svg'); ?>" alt="HT">
									<span>Haiti</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Honduras') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/hn.svg'); ?>" alt="HN">
									<span>Honduras</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Hong Kong') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/hk.svg'); ?>" alt="HK">
									<span>Hong Kong</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Hungary') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/hu.svg'); ?>" alt="HU">
									<span>Hungary</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Iceland') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/is.svg'); ?>" alt="IS">
									<span>Iceland</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('India') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/in.svg'); ?>" alt="IN">
									<span>India</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Indonesia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/id.svg'); ?>" alt="ID">
									<span>Indonesia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Iran') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ir.svg'); ?>" alt="IR">
									<span>Iran</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Ireland') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ie.svg'); ?>" alt="IE">
									<span>Ireland</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Israel') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/il.svg'); ?>" alt="IL">
									<span>Israel</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Italy') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/it.svg'); ?>" alt="IT">
									<span>Italy</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Jamaica') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/jm.svg'); ?>" alt="JM">
									<span>Jamaica</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Japan') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/jp.svg'); ?>" alt="JP">
									<span>Japan</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Jordan') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/jo.svg'); ?>" alt="JO">
									<span>Jordan</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Kazakhstan') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/kz.svg'); ?>" alt="KZ">
									<span>Kazakhstan</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Kenya') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ke.svg'); ?>" alt="KE">
									<span>Kenya</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Kiribati') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ki.svg'); ?>" alt="KI">
									<span>Kiribati</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Korea (South)') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/kp.svg'); ?>" alt="KP">
									<span>Korea (South)</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Kuwait') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/kw.svg'); ?>" alt="KW">
									<span>Kuwait</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Lebanon') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/lb.svg'); ?>" alt="LB">
									<span>Lebanon</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Lesotho') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ls.svg'); ?>" alt="LS">
									<span>Lesotho</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Liberia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/lr.svg'); ?>" alt="LR">
									<span>Liberia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Libya') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ly.svg'); ?>" alt="LY">
									<span>Libya</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Lithuania') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/lt.svg'); ?>" alt="LT">
									<span>Lithuania</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Madagascar') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/mg.svg'); ?>" alt="MG">
									<span>Madagascar</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Malawi') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/mw.svg'); ?>" alt="MW">
									<span>Malawi</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Malaysia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/my.svg'); ?>" alt="MY">
									<span>Malaysia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Maldives') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/mv.svg'); ?>" alt="MV">
									<span>Maldives</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Mali') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ml.svg'); ?>" alt="ML">
									<span>Mali</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Malta') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/mt.svg'); ?>" alt="MT">
									<span>Malta</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Marshall Islands') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/mh.svg'); ?>" alt="MH">
									<span>Marshall Islands</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Mauritania') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/mr.svg'); ?>" alt="MR">
									<span>Mauritania</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Mauritius') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/mu.svg'); ?>" alt="MU">
									<span>Mauritius</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Micronesia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/fm.svg'); ?>" alt="FM">
									<span>Micronesia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Moldova, Republic of') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/md.svg'); ?>" alt="MD">
									<span>Moldova, Republic of</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Mongolia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/mn.svg'); ?>" alt="MN">
									<span>Mongolia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Morocco') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ma.svg'); ?>" alt="MA">
									<span>Morocco</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Mozambique') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/mz.svg'); ?>" alt="MZ">
									<span>Mozambique</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Myanmar') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/mm.svg'); ?>" alt="MM">
									<span>Myanmar</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Namibia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/na.svg'); ?>" alt="NA">
									<span>Namibia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Nepal') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/np.svg'); ?>" alt="NP">
									<span>Nepal</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Netherlands') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/nl.svg'); ?>" alt="NL">
									<span>Netherlands</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Nigeria') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ng.svg'); ?>" alt="NG">
									<span>Nigeria</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Norway') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/no.svg'); ?>" alt="NO">
									<span>Norway</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Oman') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/om.svg'); ?>" alt="OM">
									<span>Oman</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Pakistan') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/pk.svg'); ?>" alt="PK">
									<span>Pakistan</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Palau') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/pw.svg'); ?>" alt="PW">
									<span>Palau</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Panama') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/pa.svg'); ?>" alt="PA">
									<span>Panama</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Papua New Guinea') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/pg.svg'); ?>" alt="PG">
									<span>Papua New Guinea</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Peru') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/pe.svg'); ?>" alt="PE">
									<span>Peru</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Philippines') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ph.svg'); ?>" alt="PH">
									<span>Philippines</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Poland') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/pl.svg'); ?>" alt="PL">
									<span>Poland</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Portugal') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/pt.svg'); ?>" alt="PT">
									<span>Portugal</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Qatar') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/qa.svg'); ?>" alt="QA">
									<span>Qatar</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Romania') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ro.svg'); ?>" alt="RO">
									<span>Romania</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Russian Federation') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ru.svg'); ?>" alt="RU">
									<span>Russian Federation</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Samoa') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ws.svg'); ?>" alt="WS">
									<span>Samoa</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Saudi Arabia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/sa.svg'); ?>" alt="SA">
									<span>Saudi Arabia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Senegal') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/sn.svg'); ?>" alt="SN">
									<span>Senegal</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Seychelles') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/sc.svg'); ?>" alt="SC">
									<span>Seychelles</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Singapore') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/sg.svg'); ?>" alt="SG">
									<span>Singapore</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Slovakia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/sk.svg'); ?>" alt="SK">
									<span>Slovakia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('South Africa') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/za.svg'); ?>" alt="ZA">
									<span>South Africa</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Spain') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/es.svg'); ?>" alt="ES">
									<span>Spain</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Sri Lanka') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/lk.svg'); ?>" alt="LK">
									<span>Sri Lanka</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Swaziland') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/sz.svg'); ?>" alt="SZ">
									<span>Swaziland</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Sweden') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/se.svg'); ?>" alt="SE">
									<span>Sweden</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Switzerland') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ch.svg'); ?>" alt="CH">
									<span>Switzerland</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Taiwan') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/tw.svg'); ?>" alt="TW">
									<span>Taiwan</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Tanzania') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/tz.svg'); ?>" alt="TZ">
									<span>Tanzania</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Thailand') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/th.svg'); ?>" alt="TH">
									<span>Thailand</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Togo') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/tg.svg'); ?>" alt="TG">
									<span>Togo</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Trinidad and Tobago') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/tt.svg'); ?>" alt="TT">
									<span>Trinidad and Tobago</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Turkey') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/tr.svg'); ?>" alt="TR">
									<span>Turkey</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Ukraine') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ua.svg'); ?>" alt="UA">
									<span>Ukraine</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('United Arab Emirates') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ua.svg'); ?>" alt="AE">
									<span>United Arab Emirates</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('United Kingdom') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ae.svg'); ?>" alt="GB">
									<span>United Kingdom</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('United States') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/gb.svg'); ?>" alt="US">
									<span>United States</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Uzbekistan') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/us.svg'); ?>" alt="UZ">
									<span>Uzbekistan</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Vanuatu') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/uz.svg'); ?>" alt="VU">
									<span>Vanuatu</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Venezuela') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/vu.svg'); ?>" alt="VE">
									<span>Venezuela</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Viet Nam') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ve.svg'); ?>" alt="VN">
									<span>Viet Nam</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Yemen') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/vn.svg'); ?>" alt="YE">
									<span>Yemen</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Zambia') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/ye.svg'); ?>" alt="ZM">
									<span>Zambia</span>
								</a> </li>
							<li>
								<a href="<?php echo base_url('buying-leads?cc=' . volgo_encrypt_message('Zimbabwe') ); ?>" >

									<img src="<?php echo base_url('assets/images/country-flags/zm.svg'); ?>" alt="ZW">
									<span>Zimbabwe</span>
								</a> </li>
						</ul>
					</div>



				</div>
				<!-- Flags Html End here -->

			</div>

		</div>
		<!-- End Flages Copy From here  -->

	</div>
</section>

<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>
