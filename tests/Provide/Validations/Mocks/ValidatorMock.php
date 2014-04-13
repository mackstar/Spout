<?php

namespace Mackstar\Spout\Provide\Validations\Mocks;

class ValidatorMock
{
	public function getMessages() {
		return [
			'message1' => 'This is message1',
			'message2' => 'This another message'
		];
	}
}