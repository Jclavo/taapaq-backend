<?php

use Illuminate\Database\Seeder;
use App\Models\TranslationDetail;
use App\Models\Translation;
// use App\Models\SystemModel;
// use App\Utils\SystemModelUtil;
use App\Utils\TranslationUtil;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $translations = [
            // (object) array('key' => '', 'translationable_id' => '',
            //                'details' => [
            //                         (object) array('value' => '', 'locale' => 'en'),
            //                         (object) array('value' => '', 'locale' => 'es'),
            //                         (object) array('value' => '', 'locale' => 'pt')]
            //                 ),

            //CRUD SECTION
            (object) array('key' => 'crud.create', 'translationable_id' => '',
                            'details' => [
                                    (object) array('value' => 'Record created successfully.', 'locale' => 'en'),
                                    (object) array('value' => 'Registro creado con exito.', 'locale' => 'es'),
                                    (object) array('value' => 'Registro criado com éxito.', 'locale' => 'pt')]
                            ),
            (object) array('key' => 'crud.read', 'translationable_id' => '',
                            'details' => [
                                    (object) array('value' => 'Record retrieved successfully.', 'locale' => 'en'),
                                    (object) array('value' => 'Registro obtenido con exito.', 'locale' => 'es'),
                                    (object) array('value' => 'Registro retornado com éxito.', 'locale' => 'pt')]
                            ),
            (object) array('key' => 'crud.update', 'translationable_id' => '',
                            'details' => [
                                    (object) array('value' => 'Record updated successfully.', 'locale' => 'en'),
                                    (object) array('value' => 'Registro actualizado con exito.', 'locale' => 'es'),
                                    (object) array('value' => 'Registro atualizado com éxito.', 'locale' => 'pt')]
                            ),
            (object) array('key' => 'crud.delete', 'translationable_id' => '',
                            'details' => [
                                    (object) array('value' => 'Record deleted successfully.', 'locale' => 'en'),
                                    (object) array('value' => 'Registro eliminado con exito.', 'locale' => 'es'),
                                    (object) array('value' => 'Registro apagado com éxito.', 'locale' => 'pt')]
                            ),
            (object) array('key' => 'crud.pagination', 'translationable_id' => '',
                            'details' => [
                                    (object) array('value' => 'Records retrieved successfully.', 'locale' => 'en'),
                                    (object) array('value' => 'Registro obtenidos con exito.', 'locale' => 'es'),
                                    (object) array('value' => 'Registros retornados com éxito.', 'locale' => 'pt')]
                            ),
            (object) array('key' => 'crud.update-date', 'translationable_id' => '',
                'details' => [
                        (object) array('value' => 'The date was updated.', 'locale' => 'en'),
                        (object) array('value' => 'A fecha fue actualizada.', 'locale' => 'es'),
                        (object) array('value' => 'A data foi atualizada.', 'locale' => 'pt')]
             ),
             (object) array('key' => 'crud.annulled', 'translationable_id' => '',
                'details' => [
                        (object) array('value' => 'The record was annulled.', 'locale' => 'en'),
                        (object) array('value' => 'El registro fue anulado.', 'locale' => 'es'),
                        (object) array('value' => 'O registro foi anulado.', 'locale' => 'pt')]
             ),   

                         //STAGES SECTION
            (object) array('key' => 'stage.already-canceled', 'translationable_id' => '',
            'details' => [
                    (object) array('value' => 'There is not possible to finish the action requested, because the record was canceled.', 'locale' => 'en'),
                    (object) array('value' => 'No es posible concluir la acción solicitada porque el registro fue cancelado.', 'locale' => 'es'),
                    (object) array('value' => 'Não é possivel concluir a ação porque o registro foi cancelado.', 'locale' => 'pt')]
            ),
            (object) array('key' => 'stage.already-delivered', 'translationable_id' => '',
            'details' => [
                    (object) array('value' => 'There is not possible to finish the action requested, because the record was delivered.', 'locale' => 'en'),
                    (object) array('value' => 'No es posible concluir la acción solicitada porque el registro fue entregado.', 'locale' => 'es'),
                    (object) array('value' => 'Não é possivel concluir a ação porque o registro foi entregado.', 'locale' => 'pt')]
            ),
            (object) array('key' => 'stage.already-paid', 'translationable_id' => '',
            'details' => [
                    (object) array('value' => 'There is not possible to finish the action requested, because the record was paid.', 'locale' => 'en'),
                    (object) array('value' => 'No es posible concluir la acción solicitada porque el registro fue pagado.', 'locale' => 'es'),
                    (object) array('value' => 'Não é possivel concluir a ação porque o registro foi pagado.', 'locale' => 'pt')]
            ),
            (object) array('key' => 'stage.already-annulled', 'translationable_id' => '',
            'details' => [
                    (object) array('value' => 'There is not possible to finish the action requested, because the record was annulled.', 'locale' => 'en'),
                    (object) array('value' => 'No es posible concluir la acción solicitada porque el registro fue anulado.', 'locale' => 'es'),
                    (object) array('value' => 'Não é possivel concluir a ação porque o registro foi anulado.', 'locale' => 'pt')]
            ),
            (object) array('key' => 'stage.updated', 'translationable_id' => '',
            'details' => [
                    (object) array('value' => 'The stage was updated.', 'locale' => 'en'),
                    (object) array('value' => 'El estado fue actualizado.', 'locale' => 'es'),
                    (object) array('value' => 'O estado foi atualizado.', 'locale' => 'pt')]
            ),

            //INVOICE SECTION
            (object) array('key' => 'invoice.total-negative', 'translationable_id' => '',
                            'details' => [
                                    (object) array('value' => 'Invoice total is negative.', 'locale' => 'en'),
                                    (object) array('value' => 'El total es negativo.', 'locale' => 'es'),
                                    (object) array('value' => 'O total é negativo.', 'locale' => 'pt')]
                            ),
            (object) array('key' => 'invoice.anull', 'translationable_id' => '',
                            'details' => [
                                     (object) array('value' => 'Invoice Annulled successfully.', 'locale' => 'en'),
                                     (object) array('value' => 'Factura anulada con exito.', 'locale' => 'es'),
                                     (object) array('value' => 'Fatura anulada com éxito.', 'locale' => 'pt')]
                            ),   
            (object) array('key' => 'invoice.detail-not-found', 'translationable_id' => '',
                             'details' => [
                                      (object) array('value' => 'Invoice details not found.', 'locale' => 'en'),
                                      (object) array('value' => 'Detalle de la factura no encontrado.', 'locale' => 'es'),
                                      (object) array('value' => 'Detalhe da fatura não achado.', 'locale' => 'pt')]
                            ),
            (object) array('key' => 'invoice.already-anulled', 'translationable_id' => '',
                            'details' => [
                                     (object) array('value' => 'Invoice has already been anulled.', 'locale' => 'en'),
                                     (object) array('value' => 'La factura ya fue anulada.', 'locale' => 'es'),
                                     (object) array('value' => 'A fatura já foi anulada.', 'locale' => 'pt')]
                            ),
            (object) array('key' => 'invoice.detail-gt-subtotal', 'translationable_id' => '',
                            'details' => [
                                     (object) array('value' => 'Invoice Detail total is greater than Invoice subtotal.', 'locale' => 'en'),
                                     (object) array('value' => 'El detalhe de la factura es mayor que su subtotal.', 'locale' => 'es'),
                                     (object) array('value' => 'O detalhe da fatura é maior o que o subtotal.', 'locale' => 'pt')]
                            ),
            (object) array('key' => 'invoice.out-date', 'translationable_id' => '',
                            'details' => [
                                     (object) array('value' => 'Invoice is out the date range.', 'locale' => 'en'),
                                     (object) array('value' => 'La fatura esta fuera del intervalo de fechas.', 'locale' => 'es'),
                                     (object) array('value' => 'A fatura está fora do intervalo de datas.', 'locale' => 'pt')]
                            ),
            (object) array('key' => 'invoice.has-no-stock', 'translationable_id' => '',
                            'details' => [
                                     (object) array('value' => 'One of the items does not have stock.', 'locale' => 'en'),
                                     (object) array('value' => 'Uno de los items no tiene stock.', 'locale' => 'es'),
                                     (object) array('value' => 'Um dos items não tem stock.', 'locale' => 'pt')]
                           ),
            
            //ITEM SECTION
            (object) array('key' => 'item.has-stock', 'translationable_id' => '',
                            'details' => [
                                    (object) array('value' => 'The item has stock. It can not be modified.', 'locale' => 'en'),
                                    (object) array('value' => 'El item tiene stock, no puede ser modificado.', 'locale' => 'es'),
                                    (object) array('value' => 'O item tem stock, não pode ser modificado.', 'locale' => 'pt')]
                            ),        
            (object) array('key' => 'item.has-no-stock', 'translationable_id' => '',
                            'details' => [
                                     (object) array('value' => 'There is not enough stock available.', 'locale' => 'en'),
                                     (object) array('value' => 'El item no tiene stock.', 'locale' => 'es'),
                                     (object) array('value' => 'O item não tem stock.', 'locale' => 'pt')]
                            ), 
            
            //IDENTIFICATION SECTION
            (object) array('key' => 'identification.length', 'translationable_id' => '',
                            'details' => [
                                    (object) array('value' => 'The identification must be :digits characters for your store country.', 'locale' => 'en'),
                                    (object) array('value' => 'Sua identificação deve ter :digits caractere acorde o pais de sua empresa.', 'locale' => 'es'),
                                    (object) array('value' => 'Sua identificação deve ter :digits caractere acorde o pais de sua empresa.', 'locale' => 'pt')]
                            ),

            //PHONE SECTION
            (object) array('key' => 'phone.format', 'translationable_id' => '',
                            'details' => [
                                    (object) array('value' => 'The phone format does not match your store country.', 'locale' => 'en'),
                                    (object) array('value' => 'El formato del telefono no esta correcto com el formate del pais de su empresa.', 'locale' => 'es'),
                                    (object) array('value' => 'O formato do telefone não está certo acorde o pais de sua empresa.', 'locale' => 'pt')]
                            ),

             //ORDER SECTION
            (object) array('key' => 'order.change-stage-canceled', 'translationable_id' => '',
            'details' => [
                    (object) array('value' => 'To cancel the order, please use the another feature.', 'locale' => 'en'),
                    (object) array('value' => 'Para cancelar el pedido, por favor usa otra opción.', 'locale' => 'es'),
                    (object) array('value' => 'Para cancelar o pedido, por favor usa outra opção.', 'locale' => 'pt')]
            ),



        ];

        // TranslationUtil::customUpdateOrCreate(env('PROJECT_TAAPAQ_CODE'),'SYSTEM',$translations);

        //EXECUTE

        // $newModel = factory(SystemModel::class)->updateOrCreate(['name' => 'SYSTEM',
        //                                                  'project_id' => $this->project_id ]);

        // foreach ($this->translations as $translation) {

        // //     $translation->translationable_id < 1 ? $translation->translationable_id = 0 : null;

        //     $newTranslation = factory(Translation::class)->create(['key' => $translation->key,
        //                                                            'translationable_type' => 'App\Models\System',
        //                                                         //    'translationable_id' => $translation->translationable_id,
        //                                                         //    'model_id' => $newModel->id,
        //                                                           ]);
        //     foreach ($translation->details as $detail) {
        //         $newTranslation->details()->save(
        //             factory(TranslationDetail::class)->make(['value' => $detail->value,
        //                                                      'locale' => $detail->locale])
        //         );
        //     } 
        // }

        

        // $newModel = SystemModelUtil::createFromProjectCode(env('PROJECT_TAAPAQ_CODE'),'SYSTEM');

        foreach ($translations as $translation) {

        //     $translation->translationable_id < 1 ? $translation->translationable_id = 0 : null;

            $newTranslation = Translation::updateOrCreate(['key' => $translation->key,
                                                           'translationable_type' => 'App\Models\System',
                                                        //    'translationable_id' => $translation->translationable_id,
                                                        //    'model_id' => $newModel->id,
                                                          ]);
            foreach ($translation->details as $detail) {
                    TranslationDetail::updateOrCreate(['translation_id' => $newTranslation->id, 'locale' => $detail->locale],
                                                        ['value' => $detail->value,]);
            } 
        }

    }    

}
