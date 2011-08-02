<?php
class Criterio extends AppModel {
	var $name = 'Criterio';
	var $displayField = 'pregunta';
	var $primaryKey = 'id_criterio';
	
	var $hasMany = array(
		'TamanoDesafio' => array(
			'className' => 'TamanoDesafio',
			'foreignKey' => 'id_criterio',
			'dependent' => true
		),
		'InformacionDesafio' => array(
			'className' => 'InformacionDesafio',
			'foreignKey' => 'id_criterio',
			'dependent' => true
		)
	); 
	var $validate = array(
		'pregunta' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'The question for the criterion must be non-empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'respuesta_1' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'The possible answers for the criterion cannot be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'respuesta_2' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'The possible answers for the criterion cannot be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tamano_pack' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'The pack size must be a numeric value.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'costo_pack' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'The pack cost must be a numeric value',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'costo_envio' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El costo de enviar un documento (los puntos con los que se puede enviar) deben ser un valor numérico',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'bono_documento_enviado_validado' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'The bonus points received for a validated document must be a numeric value',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'funcion_penalizacion_a' => array(
			'decimal' => array(
				'rule' => array('numeric'),
				'message' => 'The lineal factor on the penalization function must be a numeric value.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'funcion_penalizacion_b' => array(
			'decimal' => array(
				'rule' => array('numeric'),
				'message' => 'The constant value on the penalization function must be a numeric value.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'funcion_despenalizacion_a' => array(
			'decimal' => array(
				'rule' => array('numeric'),
				'message' => 'The lineal factor on the despenalization function must be a numeric value.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'funcion_despenalizacion_b' => array(
			'decimal' => array(
				'rule' => array('numeric'),
				'message' => 'The constant value on the despenalization function must be a numeric value.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tamano_minimo_desafio' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'The minimum size of a challenge must be a numeric value.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	// actualiza los documentos agregando el nuevo criterio a InfoDesafio
	// y los usuarios, con TamanoDesafio
	function afterSave($created) {
		if($created) {
			$ds = $this->getDataSource();
			
			$ds->begin($this);
			if(
				$this->InformacionDesafio->massCreateAfterCriteria($this->id) &&
				$this->TamanoDesafio->massCreateAfterCriteria($this->id, $this->field('tamano_minimo_desafio', array('id_criterio' => $this->id))))
				$ds->commit($this);
			else
				$ds->rollback($this);
		}		
	}
	
	
	function getRandomCriteria() {
		$criterios = $this->find('all');
		
		if(empty($criterios))
			return null;
		
		return $criterios[array_rand($criterios)];
	}

}
?>
