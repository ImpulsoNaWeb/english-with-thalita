<?php
use App\Models\Servico;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$mapeamento = [
    1 => 'servicos/conversacao.png',
    2 => 'servicos/business.png',
    3 => 'servicos/viagens.png',
    4 => 'servicos/cidade.png',
    5 => 'servicos/empresas.png',
];

foreach ($mapeamento as $id => $path) {
    $s = Servico::find($id);
    if ($s) {
        $s->imagem = $path;
        $s->save();
        echo "Atualizado ID $id para $path\n";
    }
}
