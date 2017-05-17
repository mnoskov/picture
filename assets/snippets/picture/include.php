<?php

	$images   = [];
	$fallback = false;

	if ( isset( $data ) ) {
		if ( !is_array( $data ) ) {
			$data = json_decode( $data );
		}
		
		if ( !is_array( $data ) ) {
			return '$data invalid';
		}
		
		foreach ( $data as $src ) {
			if ( !empty( $src->fallback ) ) {
				$fallback = $src;
				break;
			}
		}
		
		if ( !$fallback ) {
			$fallback = reset( $data );
		}
		
		if ( empty( $fallback->alt ) ) {
			$fallback->alt = '';
		}
		
		if ( empty( $fallback->width ) || empty( $fallback->height ) ) {
			// retrieve from file
		}
		
		$wratio = $fallback->width / $fallback->height;
		$hratio = $fallback->height / $fallback->width;
		
		foreach ( $data as $i => $src ) {
			if ( empty( $src->width ) && !empty( $src->height ) ) {
				$src->width = $src->height * $wratio;
			}
			
			if ( empty( $src->height ) && !empty( $src->width ) ) {
				$src->height = $src->width * $hratio;
			}
			
			if ( empty( $src->width ) || empty( $src->height ) ) {
				$src->width  = $fallback->width;
				$src->height = $fallback->height;
			}
			
			$src->image = $modx->runSnippet( 'phpthumb', [ 
				'input'   => $source, 
				'options' => 'w=' . $src->width . ',h=' . $src->height . ( !empty( $phpthumboptions ) ? ',' . $phpthumboptions : '' ) 
			] );
			
			$src->set = [
				'1x' => $src->image,
				'2x' => $modx->runSnippet( 'phpthumb', [ 
					'input'   => $source, 
					'options' => 'w=' . ( $src->width * 2 ) . ',h=' . ( $src->height * 2 ) . ( !empty( $phpthumboptions ) ? ',' . $phpthumboptions : '' ) 
				] )
			];
			
			array_walk( $src->set, function( &$value, $key ) {
				$value = "$value $key";
			} );

			$src->set = implode( ', ', $src->set );
			
			$src->sign  = $src->media[0] == '>' ? 0 : 1;
			$src->media = intval( ltrim( $src->media, '<>' ) );
			
			if ( $src->sign ) {
				$src->media--;
			}
			
			$images[] = '<source srcset="' . $src->set . '" media="(' . ( $src->sign ? 'max' : 'min' ) . '-width: ' . $src->media . 'px)">';
		}
		
		$images[] = '<img src="' . $fallback->image . '" srcset="' . $fallback->set . '" alt="' . $fallback->alt . '" class="img-fluid">';

		//sort by sign and media
	}

	return '<picture>' . implode( $images ) . '</picture>';
