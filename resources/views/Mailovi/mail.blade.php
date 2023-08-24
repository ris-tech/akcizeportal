<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if gte mso 9]>
	<xml>
		<o:OfficeDocumentSettings>
		<o:AllowPNG/>
		<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="format-detection" content="date=no" />
	<meta name="format-detection" content="address=no" />
	<meta name="format-detection" content="telephone=no" />
	<meta name="x-apple-disable-message-reformatting" />
    <!--[if !mso]><!-->
   	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />
    <!--<![endif]-->
	<title>Email Template</title>
	<!--[if gte mso 9]>
	<style type="text/css" media="all">
		sup { font-size: 100% !important; }
	</style>
	<![endif]-->


	<style type="text/css" media="screen">
		/* Linked Styles */
		body { padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#f4f4f4; -webkit-text-size-adjust:none }
		a { color:#b04d4d; text-decoration:none }
		p { padding:0 !important; margin:0 !important }
		img { -ms-interpolation-mode: bicubic; /* Allow smoother rendering of resized image in Internet Explorer */ }
		.mcnPreviewText { display: none !important; }


		/* Mobile styles */
		@media only screen and (max-device-width: 480px), only screen and (max-width: 480px) {
			u + .body .gwfw { width:100% !important; width:100vw !important; }

			.m-shell { width: 100% !important; min-width: 100% !important; }

			.m-center { text-align: center !important; }

			.center { margin: 0 auto !important; }
			.p10 { padding: 10px !important; }
			.p30-20 { padding: 30px 20px !important; }

			.td { width: 100% !important; min-width: 100% !important; }

			.m-br-15 { height: 15px !important; }

			.m-td,
			.m-hide { display: none !important; width: 0 !important; height: 0 !important; font-size: 0 !important; line-height: 0 !important; min-height: 0 !important; }

			.m-block { display: block !important; }

			.fluid-img img { width: 100% !important; max-width: 100% !important; height: auto !important; }
			.logo img { width: 100% !important; max-width: 190px !important; height: auto !important; }

			.column,
			.column-top,
			.column-bottom { float: left !important; width: 100% !important; display: block !important; }

			.content-spacing { width: 15px !important; }
		}
	</style>
</head>
<body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#f4f4f4; -webkit-text-size-adjust:none;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4" class="gwfw">
		<tr>
			<td align="center" valign="top" style="padding: 50px 10px;" class="p10">
				<table width="650" border="0" cellspacing="0" cellpadding="0" class="m-shell">
					<tr>
						<td class="td" bgcolor="#ffffff" style="border-radius: 6px; width:650px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
							<!-- Header -->
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td bgcolor="#ffffff" style="padding: 25px 50px; border-bottom: 2px solid #f4f4f4; border-radius: 6px 6px 0px 0px;" class="p30-20">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td width="200" class="logo img" style="font-size:0pt; line-height:0pt; text-align:left;"><a href="https://www.akcize.rs" alt="Akcize.rs Logo"><img src="https://akcize.rs/wp-content/uploads/2023/07/akcize_logo.png" width="191" height="107" border="0" alt="Akcize.rs Logo" /></a></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
							<!-- END Header -->

							<!-- CTA -->
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td style="padding: 50px; border-bottom: 2px solid #f4f4f4;" class="p30-20">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td class="h3" style="padding-bottom: 30px; color:#555555; font-family:\'Montserrat\', Arial, sans-serif; font-size:20px; line-height:25px; text-align:left;"><multiline>@if ($docType == 'ugovor') {{ $formalno }} {{ $ime }} {{ $prezime }} @else Poštovane dame i gospodo @endif</multiline></td>
											</tr>
											<tr>
												<td>
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td width="70%" valign="top" style="font-size:12pt; line-height:15pt; text-align:left;vertical-align:top;padding:0px 20px 0px 0px;">
																	<table valign="top" width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td style="font-family:\'Montserrat\', Arial, sans-serif;font-size:10pt; line-height:15pt; text-align:left;padding: 0px 0px 20px 0px;">
																					U dodatku vam šaljemo {{ $docTypeName }}.
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
                                            <tr>
												<td>
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td width="70%" valign="top" style="font-size:12pt; line-height:15pt; text-align:left;vertical-align:top;padding:0px 20px 0px 0px;">
																	<table valign="top" width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td style="font-family:\'Montserrat\', Arial, sans-serif;font-size:10pt; line-height:15pt; text-align:left;padding: 0px 0px 20px 0px;">
																					Za više informacija stojimo na raspolaganju.
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
                                            <tr>
												<td>
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td width="70%" valign="top" style="font-size:12pt; line-height:15pt; text-align:left;vertical-align:top;padding:0px 20px 0px 0px;">
																	<table valign="top" width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td style="font-family:\'Montserrat\', Arial, sans-serif;font-size:10pt; line-height:15pt; text-align:left;padding: 0px 0px 20px 0px;">
																					Sa poštovanjem Akcize.rs Team
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
							<!-- END CTA -->

							<!-- Footer -->
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td style="padding: 0px 0px 0px 0px;" class="p30-20">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td style="padding-bottom: 32px;">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td valign="top" align="center" style="font-family:\'Montserrat\', Arial, sans-serif;font-size:8pt; line-height:15pt; text-align:center;padding: 0px 0px 0px 0px; color:#aaaaaa;vertical-align:top;">
																Akcize.rs | Solunska 14 | 15300 Loznica | Telefon: +381 (0) 69 - 284 93 8
															</td>
														</tr>
														<tr>
															<td valign="top" align="center" style="font-family:\'Montserrat\', Arial, sans-serif;font-size:8pt; line-height:15pt; text-align:center;padding: 0px 0px 0px 0px; color:#aaaaaa;vertical-align:top;">
																Email: info@akcize.rs | Webseite: https://www.akcize.rs
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
							<!-- END Footer -->
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
