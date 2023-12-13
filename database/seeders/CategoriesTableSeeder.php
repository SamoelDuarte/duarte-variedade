<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clothes = Category::create(['name' => 'Roupas', 'status' => true, 'category_ml' => 'roupas_ml']);
        Category::create(['name' => 'Roupas Femininas', 'status' => true, 'parent_id' => $clothes->id, 'category_ml' => 'roupas_femininas_ml']);
        Category::create(['name' => 'Roupas Masculinas', 'status' => true, 'parent_id' => $clothes->id, 'category_ml' => 'roupas_masculinas_ml']);
        Category::create(['name' => 'Roupas Infantis Masculinas', 'status' => true, 'parent_id' => $clothes->id, 'category_ml' => 'roupas_infantis_masculinas_ml']);
        Category::create(['name' => 'Roupas Infantis Femininas', 'status' => true, 'parent_id' => $clothes->id, 'category_ml' => 'roupas_infantis_femininas_ml']);

        $shoes = Category::create(['name' => 'Calçados', 'status' => true, 'category_ml' => 'calcados_ml']);
        Category::create(['name' => 'Calçados Femininos', 'status' => true, 'parent_id' => $shoes->id, 'category_ml' => 'calcados_femininos_ml']);
        Category::create(['name' => 'Calçados Masculinos', 'status' => true, 'parent_id' => $shoes->id, 'category_ml' => 'calcados_masculinos_ml']);
        Category::create(['name' => 'Calçados Infantis Masculinos', 'status' => true, 'parent_id' => $shoes->id, 'category_ml' => 'calcados_infantis_masculinos_ml']);
        Category::create(['name' => 'Calçados Infantis Femininos', 'status' => true, 'parent_id' => $shoes->id, 'category_ml' => 'calcados_infantis_femininos_ml']);

        $watches = Category::create(['name' => 'Relógios', 'status' => true, 'category_ml' => 'relogios_ml']);
        Category::create(['name' => 'Relógios Femininos', 'status' => true, 'parent_id' => $watches->id, 'category_ml' => 'relogios_femininos_ml']);
        Category::create(['name' => 'Relógios Masculinos', 'status' => true, 'parent_id' => $watches->id, 'category_ml' => 'relogios_masculinos_ml']);
        Category::create(['name' => 'Relógios Infantis Masculinos', 'status' => true, 'parent_id' => $watches->id, 'category_ml' => 'relogios_infantis_masculinos_ml']);
        Category::create(['name' => 'Relógios Infantis Femininos', 'status' => true, 'parent_id' => $watches->id, 'category_ml' => 'relogios_infantis_femininos_ml']);

        $electronics = Category::create(['name' => 'Eletrônicos', 'status' => true, 'category_ml' => 'eletronicos_ml']);
        Category::create(['name' => 'Pen drives USB', 'status' => true, 'parent_id' => $electronics->id, 'category_ml' => 'pendrives_usb_ml']);
        Category::create(['name' => 'Fones de Ouvido', 'status' => true, 'parent_id' => $electronics->id, 'category_ml' => 'fones_de_ouvido_ml']);
        Category::create(['name' => 'Caixas de Som Portáteis', 'status' => true, 'parent_id' => $electronics->id, 'category_ml' => 'caixas_de_som_portateis_ml']);
        Category::create(['name' => 'Teclados', 'status' => true, 'parent_id' => $electronics->id, 'category_ml' => 'teclados_ml']);


        // Categorias
        $veiculos = Category::create(['name' => 'Acessórios para Veículos', 'status' => true, 'category_ml' => 'MLB5672']);
        $agro = Category::create(['name' => 'Agro', 'status' => true, 'category_ml' => 'MLB271599']);
        $alimentos_bebidas = Category::create(['name' => 'Alimentos e Bebidas', 'status' => true, 'category_ml' => 'MLB1403']);
        $animais = Category::create(['name' => 'Animais', 'status' => true, 'category_ml' => 'MLB1071']);
        $antiguidades = Category::create(['name' => 'Antiguidades e Coleções', 'status' => true, 'category_ml' => 'MLB1367']);
        $artes_papelaria = Category::create(['name' => 'Arte, Papelaria e Armarinho', 'status' => true, 'category_ml' => 'MLB1368']);
        $bebes = Category::create(['name' => 'Bebês', 'status' => true, 'category_ml' => 'MLB1384']);
        $beleza_cuidado_pessoal = Category::create(['name' => 'Beleza e Cuidado Pessoal', 'status' => true, 'category_ml' => 'MLB1246']);
        $brinquedos_hobbies = Category::create(['name' => 'Brinquedos e Hobbies', 'status' => true, 'category_ml' => 'MLB1132']);
        $calcados_roupas_bolsas = Category::create(['name' => 'Calçados, Roupas e Bolsas', 'status' => true, 'category_ml' => 'MLB1430']);
        // Continuação das Categorias
        $cameras_acessorios = Category::create(['name' => 'Câmeras e Acessórios', 'status' => true, 'category_ml' => 'MLB1039']);
        $carros_motos_outros = Category::create(['name' => 'Carros, Motos e Outros', 'status' => true, 'category_ml' => 'MLB1743']);
        $casa_moveis_decoracao = Category::create(['name' => 'Casa, Móveis e Decoração', 'status' => true, 'category_ml' => 'MLB1574']);
        $celulares_telefones = Category::create(['name' => 'Celulares e Telefones', 'status' => true, 'category_ml' => 'MLB1051']);
        $construcao = Category::create(['name' => 'Construção', 'status' => true, 'category_ml' => 'MLB1500']);
        $eletrodomesticos = Category::create(['name' => 'Eletrodomésticos', 'status' => true, 'category_ml' => 'MLB5726']);
        $eletronicos_audio_video = Category::create(['name' => 'Eletrônicos, Áudio e Vídeo', 'status' => true, 'category_ml' => 'MLB1000']);
        $esportes_fitness = Category::create(['name' => 'Esportes e Fitness', 'status' => true, 'category_ml' => 'MLB1276']);
        $ferramentas = Category::create(['name' => 'Ferramentas', 'status' => true, 'category_ml' => 'MLB263532']);
        $festas_lembrancinhas = Category::create(['name' => 'Festas e Lembrancinhas', 'status' => true, 'category_ml' => 'MLB12404']);
        $games = Category::create(['name' => 'Games', 'status' => true, 'category_ml' => 'MLB1144']);
        $imoveis = Category::create(['name' => 'Imóveis', 'status' => true, 'category_ml' => 'MLB1459']);
        $industria_comercio = Category::create(['name' => 'Indústria e Comércio', 'status' => true, 'category_ml' => 'MLB1499']);
        $informatica = Category::create(['name' => 'Informática', 'status' => true, 'category_ml' => 'MLB1648']);
        $ingressos = Category::create(['name' => 'Ingressos', 'status' => true, 'category_ml' => 'MLB218519']);
        $instrumentos_musicais = Category::create(['name' => 'Instrumentos Musicais', 'status' => true, 'category_ml' => 'MLB1182']);
        $joias_relogios = Category::create(['name' => 'Joias e Relógios', 'status' => true, 'category_ml' => 'MLB3937']);
        $livros_revistas_comics = Category::create(['name' => 'Livros, Revistas e Comics', 'status' => true, 'category_ml' => 'MLB1196']);
        $musica_filmes_seriados = Category::create(['name' => 'Música, Filmes e Seriados', 'status' => true, 'category_ml' => 'MLB1168']);
        $suade = Category::create(['name' => 'Saúde', 'status' => true, 'category_ml' => 'MLB264586']);
        $servicos = Category::create(['name' => 'Serviços', 'status' => true, 'category_ml' => 'MLB1540']);
        $mais_categorias = Category::create(['name' => 'Mais Categorias', 'status' => true, 'category_ml' => 'MLB1953']);
    }
}
