<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Models\Produtos;

class ProdutoCsvJob implements ShouldQueue
{
    use Queueable;

    private $arquivo;

    /**
     * Create a new job instance.
     */
    public function __construct($arquivo)
    {
        $this->arquivo = $arquivo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $produtoArquivo = Reader::createFromPath(storage_path('app/public/'.$this->arquivo),'r');

        $produtoArquivo->setDelimiter(";");
        $produtoArquivo->setHeaderOffset(0);

        $offset = 0;
        $limit = 100;

        while(true) {
            $stmt = (new Statement())->offset($offset)->limit($limit);

            $registros = $stmt->process($produtoArquivo);

            if(count($registros) === 0) {
                break;
            }

            foreach($registros As $r) {                
                $dados = [
                    "fornecedor_id" => 1,
                    "referencia" => $r['referencia'],
                    "nome" => $r['nome'],
                    "cor" => $r['cor'],
                    "preco" => $r['preco'],
                ];

                Produtos::create($dados);
            }

            $offset+= $limit;
        }

        $failedJobs = DB::table('failed_jobs')
            ->orderBy('failed_at', 'desc')
            ->count();

        if($failedJobs == 0) {
            $msg = "Arquivo importado com sucesso";
        } else {
            $msg = "Ocorreu um erro e o arquivo não foi importado";
        }

        Mail::raw($msg, function ($message) {
                $message->from('figalexandre@gmail.com', 'Alexandre');
                $message->sender('alevaristofig@gmail.com', 'Alexandre');
                $message->to('alevaristofig@gmail.com', 'Alexandre');
        });
    }
}
