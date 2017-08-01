<?php
/**
 * Custom Customizer Control for Homepage Features
 *
 * @package Ansel
 */

if ( class_exists( 'WP_Customize_Control' ) ) :
	class Ansel_Select_Homepage_Feature_Control extends WP_Customize_Control {

		public function render_content() {
			if ( empty( $this->choices ) )
				return; ?>

			<label>
				<?php
					if ( ! empty( $this->label ) ) : ?>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php
					endif;

				if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
					<?php
				endif; ?>

				<select <?php $this->link(); ?>>

					<?php
						$choices = $this->choices;
						$types = $choices['types'];
						$options = $choices['options'];

						echo '<option value="select"' . selected( $this->value(), 'select', false ) . '>' . esc_html__( '— Select —', 'ansel' ) . '</option>';

						if ( ! empty( $options['pages'] ) ) {
							echo '<optgroup label="' . esc_html( $types['pages_label'] ) . '">';

							foreach ( $options['pages'] as $value => $label ) {
								echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . esc_html( $label ) . '</option>';
							}

							echo '</optgroup>';
						}

					if ( ! empty( $options['portfolio_types'] ) ) {
						echo '<optgroup label="' . esc_html( $types['portfolio_types_label'] ) . '">';

						foreach ( $options['portfolio_types'] as $value => $label ) {
							echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . esc_html( $label ) . '</option>';
						}

						echo '</optgroup>';
					}

					if ( ! empty( $options['categories'] ) ) {
						echo '<optgroup label="' . esc_html( $types['categories_label'] ) . '">';

						foreach ( $options['categories'] as $value => $label ) {
							echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . esc_html( $label ) . '</option>';
						}

						echo '</optgroup>';
					} ?>
				</select>
			</label>

			<?php
		} //render_content()
	} // Ansel_Select_Homepage_Feature_Control()
endif;
