<?php

namespace Tests\Feature;

use App\Models\Carro;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class CarrosControllerTest extends TestCase
{
    protected $baseRoute = "/carros";

    // A cada teste será efetuada a "migration" para limpar as tabelas
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate:fresh', ['--env' => 'testing']);
        // Artisan::call('db:seed', ['--env'=>'testing']);
    }
    private function addCarro()
    {
        $content = $this->post("{$this->baseRoute}", ["modelo" => "ModeloTest", "marca" => "MarcaTest", "ano" => "2020-01-01"])->getContent();
        return json_decode($content, true);
    }


    public function test_get_all_carros()
    {
        $this->addCarro();
        $this->addCarro();
        $resp =  $this->get("{$this->baseRoute}");
        $content = $resp->getContent();
        $decode = json_decode($content);
        $resp->assertOk();
        $this->assertEquals("array", getType($decode));
        $this->assertEquals(2, count($decode));
    }
    public function test_get_carro_with_correct_id()
    {
        $carro = $this->addCarro();

        $resp =  $this->get("{$this->baseRoute}/{$carro["id"]}");
        $content = $resp->getContent();
        $decode = json_decode($content);

        $resp->assertOk();
        $this->assertStringContainsString($carro["modelo"], $content);
    }
    public function test_get_carro_wih_wrong_id()
    {
        $carro = $this->addCarro();

        $resp =  $this->get("{$this->baseRoute}/3243");
        $content = $resp->getContent();
        $decode = json_decode($content);

        $resp->assertNotFound();
    }

    public function test_delete_carro_with_correct_id()
    {
        $carro = $this->addCarro();

        $resp =  $this->call("DELETE", "{$this->baseRoute}/{$carro["id"]}");
        $content = $resp->getContent();
        $decode = json_decode($content);

        $resp->assertOk();
        $this->assertStringContainsString($carro["modelo"], $content);
    }
    public function test_delete_carro_with_wrong_id()
    {
        $carro = $this->addCarro();

        $resp =  $this->call("DELETE", "{$this->baseRoute}/5454534}");
        $content = $resp->getContent();
        $decode = json_decode($content);

        $resp->assertNotFound();
        $this->assertStringNotContainsString($carro["modelo"], $content);
    }
    public function test_add_carro_correct()
    {
        $carro = ["modelo" => "Super", "marca" => "ultra", "ano" => "2020-01-01"];
        $resp =  $this->post("{$this->baseRoute}", $carro);
        $content = $resp->getContent();
        $decode = json_decode($content);

        $resp->assertStatus(201);
        $this->assertStringContainsString($carro["modelo"], $content);
        $this->assertStringContainsString($carro["marca"], $content);
    }
    public function test_add_carro_wrong_fields()
    {

        // Ano Errado
        $resp1 =  $this->post("{$this->baseRoute}", [
            "modelo" => "modelo ok",
            "marca" => "marca ok",
            "data" => "not at data",
        ]);

        $resp1->assertStatus(422)->assertSee("ano");

        // Modelo Errado
        $resp2 =  $this->post("{$this->baseRoute}", [
            "marca" => "marca ok",
            "data" => "2020-01-01",
        ]);

        $resp2->assertStatus(422)->assertSee("modelo");

        // Marca Errado
        $resp3 =  $this->post("{$this->baseRoute}", [
            "modelo" => "modelo ok",
            "data" => "2020-01-01",
        ]);

        $resp3->assertStatus(422)->assertSee("marca");
    }

    public function test_put_carro_correct()
    {
        $carro = $this->addCarro();
        $id = $carro["id"];
        $carro["modelo"] = "Modelo Alterado";
        $carro["marca"] = "Marca Alterada";

        $resp =  $this->put("{$this->baseRoute}/{$id}", $carro);

        $resp->assertOk()->assertSee("Modelo Alterado")->assertSee("Marca Alterada");
    }
    public function test_put_carro_wrong_fields_and_id()
    {
        $carro = $this->addCarro();
        $id = $carro["id"];
        $carro["modelo"] = "Modelo Alterado";
        $carro["marca"] = "Marca Alterada";

        $resp1 =  $this->put("{$this->baseRoute}/3242432", $carro);
        $resp1->assertNotFound();

        $resp2 =  $this->put("{$this->baseRoute}/{$id}", [
            "modelo" => "modelo alterado",
            "marca" => "marca alterada",
            "ano" => "not a data"
        ]);
        $resp2->assertStatus(422)->assertSee("ano");

        $resp3 =  $this->put("{$this->baseRoute}/{$id}", [
            "modelo" => "",
            "marca" => "marca alterada",
            "ano" => "2020-01-01",
        ]);
        $resp3->assertStatus(422)->assertSee("modelo");

        $resp4 =  $this->put("{$this->baseRoute}/{$id}", [
            "modelo" => "modelo alterado",
            "marca" => "",
            "ano" => "2020-01-01",
        ]);
        $resp4->assertStatus(422)->assertSee("marca");
    }
}
