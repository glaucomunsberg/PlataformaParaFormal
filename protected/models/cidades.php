<?php

/**
 * This is the model class for table "cidades".
 *
 * The followings are the available columns in table 'cidades':
 * @property string $id
 * @property string $descricao
 * @property string $longitude
 * @property string $latitude
 * @property string $dt_cadastro
 */
class cidades extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return cidades the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cidades';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descricao, longitude, latitude', 'required'),
			array('descricao', 'length', 'max'=>255),
			array('longitude, latitude', 'length', 'max'=>20),
			array('dt_cadastro', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, descricao, longitude, latitude, dt_cadastro', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'descricao' => 'Descricao',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
			'dt_cadastro' => 'Dt Cadastro',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);

		$criteria->compare('descricao',$this->descricao,true);

		$criteria->compare('longitude',$this->longitude,true);

		$criteria->compare('latitude',$this->latitude,true);

		$criteria->compare('dt_cadastro',$this->dt_cadastro,true);

		return new CActiveDataProvider('cidades', array(
			'criteria'=>$criteria,
		));
	}
}