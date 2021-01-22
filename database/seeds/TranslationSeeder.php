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
                                    (object) array('value' => 'Registros obtenidos con exito.', 'locale' => 'es'),
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

             (object) array('key' => 'crud.assign', 'translationable_id' => '',
             'details' => [
                         (object) array('value' => 'Record assigned successfully.', 'locale' => 'en'),
                         (object) array('value' => 'Registro assignado correctamente.', 'locale' => 'es'),
                         (object) array('value' => 'Registro atribuido com successo', 'locale' => 'pt')]
             ),
             (object) array('key' => 'crud.remove', 'translationable_id' => '',
             'details' => [
                         (object) array('value' => 'Record removed successfully.', 'locale' => 'en'),
                         (object) array('value' => 'Registro removido correctamente.', 'locale' => 'es'),
                         (object) array('value' => 'Registro removido com successo', 'locale' => 'pt')]
             ),
             (object) array('key' => 'crud.remove.error', 'translationable_id' => '',
             'details' => [
                         (object) array('value' => 'Record can not be removed.', 'locale' => 'en'),
                         (object) array('value' => 'Registro no puede ser removido.', 'locale' => 'es'),
                         (object) array('value' => 'Registro não pode ser removida.', 'locale' => 'pt')]
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
            (object) array('key' => 'item.is-in-used', 'translationable_id' => '',
                           'details' => [
                                (object) array('value' => 'Item belongs to a transaction. Can not be deleted.', 'locale' => 'en'),
                                (object) array('value' => 'El item ya está siendo usado en una transacion. No puede ser eliminado.', 'locale' => 'es'),
                                (object) array('value' => 'O item já está sendo usando numa transação. Não pode ser apagado', 'locale' => 'pt')]
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

            //USER SECTION
            (object) array('key' => 'user.login.success', 'translationable_id' => '',
            'details' => [
                        (object) array('value' => 'User login successfully.', 'locale' => 'en'),
                        (object) array('value' => 'Inicio de sessión correctamente.', 'locale' => 'es'),
                        (object) array('value' => 'Início de sessão com successo', 'locale' => 'pt')]
            ),

            (object) array('key' => 'user.login.incorrect', 'translationable_id' => '',
            'details' => [
                        (object) array('value' => 'Login incorrect.', 'locale' => 'en'),
                        (object) array('value' => 'Login incorrecto.', 'locale' => 'es'),
                        (object) array('value' => 'Login errado.', 'locale' => 'pt')]
            ),

            (object) array('key' => 'user.login.password.incorrect', 'translationable_id' => '',
            'details' => [
                        (object) array('value' => 'Password incorrect.', 'locale' => 'en'),
                        (object) array('value' => 'Contraseña incorrecta.', 'locale' => 'es'),
                        (object) array('value' => 'Senha errada.', 'locale' => 'pt')]
            ),

            (object) array('key' => 'user.login.both.incorrect', 'translationable_id' => '',
            'details' => [
                        (object) array('value' => 'Login or Password incorrect.', 'locale' => 'en'),
                        (object) array('value' => 'Login o Contraseña incorrectos.', 'locale' => 'es'),
                        (object) array('value' => 'Login o Senha errados.', 'locale' => 'pt')]
            ),

            (object) array('key' => 'user.actual-password.incorrect', 'translationable_id' => '',
            'details' => [
                (object) array('value' => 'Actual password incorrect.', 'locale' => 'en'),
                (object) array('value' => 'Contraseña actual incorrecta.', 'locale' => 'es'),
                (object) array('value' => 'Senha atual errada.', 'locale' => 'pt')]
             ),

             (object) array('key' => 'user.new-password.equal', 'translationable_id' => '',
            'details' => [
                (object) array('value' => 'New password can not be same as login.', 'locale' => 'en'),
                (object) array('value' => 'La nueva contraseña no puede ser igual al Login.', 'locale' => 'es'),
                (object) array('value' => 'A nova senha atual não pode ser igual ao Login.', 'locale' => 'pt')]
             ),

             (object) array('key' => 'user.password.changed', 'translationable_id' => '',
            'details' => [
                (object) array('value' => 'Password was changed.', 'locale' => 'en'),
                (object) array('value' => 'La contraseña fue actualizada.', 'locale' => 'es'),
                (object) array('value' => 'A senha foi atualizada.', 'locale' => 'pt')]
             ),

            (object) array('key' => 'user.delete.own', 'translationable_id' => '',
            'details' => [
                        (object) array('value' => 'The logged user can not be deleted.', 'locale' => 'en'),
                        (object) array('value' => 'No puede eliminar su usuário.', 'locale' => 'es'),
                        (object) array('value' => 'Não pode apagar seu usuário ', 'locale' => 'pt')]
            ),

            (object) array('key' => 'user.not.activated', 'translationable_id' => '',
            'details' => [
                        (object) array('value' => 'Your user is not activated yet.', 'locale' => 'en'),
                        (object) array('value' => 'Su usuário aún no está activado.', 'locale' => 'es'),
                        (object) array('value' => 'Seu usuário ainda não está ativado.', 'locale' => 'pt')]
            ),

            (object) array('key' => 'user.token.invalid', 'translationable_id' => '',
            'details' => [
                        (object) array('value' => 'Token invalid.', 'locale' => 'en'),
                        (object) array('value' => 'Token invalido.', 'locale' => 'es'),
                        (object) array('value' => 'Token inválido.', 'locale' => 'pt')]
            ),

            (object) array('key' => 'user.logout', 'translationable_id' => '',
            'details' => [
                        (object) array('value' => 'User logout.', 'locale' => 'en'),
                        (object) array('value' => 'Sesión finalizada.', 'locale' => 'es'),
                        (object) array('value' => 'Sessão finalizada.', 'locale' => 'pt')]
            ),

            (object) array('key' => 'user.status.changed', 'translationable_id' => '',
            'details' => [
                (object) array('value' => 'Users status changed successfully.', 'locale' => 'en'),
                (object) array('value' => 'El estado del usuário fue actualizado.', 'locale' => 'es'),
                (object) array('value' => 'O estado do usuário foi atualizado.', 'locale' => 'pt')]
            ),


    



        ];

       
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
