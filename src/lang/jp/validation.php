<?php

return [
    'required' => ':attributeを入力してください',
    'email'    => ':attributeはメール形式で入力してください',
    'min'      => [
        'string' => ':attributeは:min文字以上で入力してください',
    ],
    'max'      => [
        'string' => ':attributeは:max文字以内で入力してください',
    ],
    'same'     => ':attributeと一致しません',
    'unique'   => ':attributeはすでに使用されています',

    'attributes' => [
        'email'    => 'メールアドレス',
        'password' => 'パスワード',
    ],
];
