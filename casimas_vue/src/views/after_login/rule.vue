<template>
    <div>
        <mainHeader></mainHeader>
        <main class="container-fulid user-content area">
            <div class="row w-100 m-0 justify-content-center rule-container">
                <div class="row w-100">
                    <h2 class="pt-3 col-12">出品利用ルール</h2>
                    <span class="col-12">
                        この利用ルール(以下、本ルールといいます)は、CASIMASが提供するサービス(以下、本サービ
                        スといいます)の利用条件を定めるものです。利用ユーザーのみなさま(以下「ユーザー」といいま
                        す)は本ルールに従って、本サービスを利用いただきます。
                    </span>
                </div>
                <div class="row w-100">
                    <p class="col-12 rule-heading">1. 適用</p>
                    <span class="col-12">本ルールは、ユーザーとCASIMASとの間の本サービスの利用に関わる一切の関係に適用されるものとします。</span>
                </div>
                <div class="row w-100">
                    <p class="col-12 rule-heading">2. 日数プランと料金設定</p>
                    <span class="col-12">
                        <p>レンタルの日数プランは「7日間」と「30日間」です。</p>
                        <p>
                            ユーザーは、このそれぞれのプランに対してのレンタル料金を設定するものとします。なお、レンタル料金の金額はユーザーが自由に設定、変更できるものとします。
                        </p>
                    </span>
                </div>
                <div class="row w-100">
                    <p class="col-12 rule-heading">3. レンタル料金の変更・商品の返却申請</p>
                    <span class="col-12">
                        <p>
                            ・レンタル料金の変更
                        </p>
                        <p class="indent">
                            ユーザが出品している商品のレンタル料金の変更は、ユーザーの申請によりいつでも変更が可能
                            なものとします。ただし、ユーザーがレンタル料金の変更の申請をする前にレンタル希望が
                            あった場合は、当該商品のレンタル料金は申請前の料金でレンタルされ、返却後にレンタル料金の変更を行います。
                        </p>
                        <p>
                            ・商品の返却申請
                        </p>
                        <p class="indent">
                            ユーザーは、出品している商品について、いつでも商品の出品の取りやめと返却の申請をできる
                            ものとします。当該商品が、レンタルされていなかった場合、3日以内にユーザーへ商品を発送
                            返却します。また、返却時の送料については、CASIMASが負担するものとします。商品がレン
                            タルされていた場合は、レンタル者から返却され、クリーニング後3日以内にユーザーへ商品を
                            発送返却します。ただし、商品がレンタルされ、レンタル者から延長希望があった場合は、以下の状況に応じて返却対応するものとします。
                        </p>
                        <table class="table m-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="w-50 p-0 text-center">先にユーザーが<br />返却申請をしていた場合</th>
                                    <th class="w-50 p-0 text-center">先にレンタル者が<br />延長申請をしていた場合</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-0">レンタル者の延長申請を棄却<br />返却・クリーニング後に<br />ユーザーへ商品を返却</td>
                                    <td class="p-0">ユーザーの返却申請を保留<br />レンタルを延長し返却・クリーニング後にユーザーへ商品を返却</td>
                                </tr>
                            </tbody>
                        </table>
                    </span>
                </div>
                <div class="row w-100">
                    <p class="col-12 rule-heading">4. 手数料</p>
                    <span class="col-12">
                        <p>
                            ユーザーは自身が出品している商品がレンタル及び購入された場合、出品・管理手数料としてこれをCASIMASに支払うものとします。出品・管理手数料は以下に示します。
                        </p>
                        <table class="table m-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="p-0 text-center"></th>
                                    <th class="p-0 text-center">7日間</th>
                                    <th class="p-0 text-center">30日間</th>
                                    <th class="p-0 text-center">購入</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-0 text-center">出品・管理手数料</td>
                                    <td class="p-0 text-center">¥500</td>
                                    <td class="p-0 text-center">¥1,000</td>
                                    <td class="p-0 text-center">販売金額の20%</td>
                                </tr>
                            </tbody>
                        </table>
                    </span>
                </div>
                <div class="row w-100">
                    <p class="col-12 rule-heading">5. 配送料・クリーニング代</p>
                    <span class="col-12">
                        ユーザーは商品がレンタルされた際の、配送料及びレンタル者から返却されたのちのクリーニング 代の実費を支払うものとします。
                    </span>
                </div>
                <div class="row w-100">
                    <p class="col-12 rule-heading">6. レンタル料の振り込み</p>
                    <span class="col-12">
                        <p>
                            ユーザーが出品している商品がレンタルされた場合、レンタル料から上記4.、5.の「出品・管理手数料」と「配送料・クリーニング代」を差し引いた金額を「月末締め、翌月15日」にCASIMASから当該ユーザーの指定口座へ振り込むものとします。
                        </p>
                        <p>
                            なお、1回のレンタルの振込金額はレンタル者から返却され、クリーニング代が確定した時点で算出しま
                            す。締め日までに算出できなかったレンタル分については翌月確定となります。
                        </p>
                    </span>
                </div>
                <div class="row w-100">
                    <p class="col-12 rule-heading">7. 商品の破損と保証</p>
                    <span class="col-12">
                        <p>
                            ユーザーが出品した商品がレンタルされ、レンタル者が当該商品を破損した場合、CASIMASはその修繕にかかった費用はすべてレンタル者に請求し、原状回復を試みます。修繕・原状回復が不可能だった場合、ユーザーに補償金として、当該商品のレンタル料の30日間の150%を支払うものとします。
                        </p>
                    </span>
                </div>
                <div class="row w-100">
                    <p class="col-12 rule-heading">8. 商品の管理</p>
                    <span class="col-12">
                        <p>
                            ユーザーから出品された商品はCASIMASが厳重に管理・保管します。CASIMASの管理上、商品が破損してしまった場合、当該商品の30日間のレンタル料の200%の金額をCASIMASからユーザーへ支払うものとします。
                        </p>
                    </span>
                </div>
                <div class="row w-100">
                    <p class="col-12 rule-heading">9. レンタル者の延滞</p>
                    <span class="col-12">
                        <p>
                            レンタル者がユーザーが出品した商品のレンタル期日を超えて商品を保持し続けた場合、CASIMASは直ちに当該レンタル者へ延滞と返却の通告を行います。
                        </p>
                    </span>
                </div>
                <div class="row w-100">
                    <p class="col-12 rule-heading">10. 責任の所在</p>
                    <span class="col-12">
                        <p>ユーザーは、以下の点を承諾したうえで、本サービスを利用するものとします。</p>
                        <p>・本ルールを遵守すること</p>
                        <p>・本サービスの利用にあたり、CASIMASが定めた手続がある場合には、当該手続に従うこと</p>
                        <p>
                            ・ユーザーが本サービスを利用する際は、内容の信頼性、正確性、完成度、有用性(有益性)などについて自身で判断し、自身の責任とリスク負担のもとで行うこと
                        </p>
                        <p>・ユーザーが本ルールを違反して、損害を被った場合、CASIMASおよびレンタル者は一切の責任を負いません</p>
                    </span>
                </div>
                <div class="row w-100">
                    <p class="col-12 rule-heading">12. 個人情報の取り扱い</p>
                    <span class="col-12">
                        <p>CASIMASがユーザーから収集した個人情報については別途定める「プライバシーポリシー」に 従い、適切に取り扱うものとします。</p>
                    </span>
                </div>
                <div class="row w-100">
                    <p class="col-12 rule-heading">13. 本ルールの変更</p>
                    <span class="col-12">
                        <p>
                            ・本ルールの内容は，法令その他本ルールに別段の定めのある事項を除いて，ユーザーに通
                            知することなく，変更することができるものとします。
                        </p>
                        <p>
                            ・CASSIMASが別途定める場合を除いて，変更後の本ルールは，CASIMASが定める方法に
                            よってユーザーに通知したときから効力を生じるものとします。
                        </p>
                    </span>
                </div>
            </div>
        </main>
        <footerMenu @changePage="changePage"></footerMenu>
    </div>
</template>
<script>
import mainHeader from '../../components/mainHeader';
import footerMenu from '../../components/footerMenu';
import methods from '../../methods';

export default {
    components: {
        mainHeader,
        footerMenu,
    },
    methods: {
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
    },
};
</script>
<style scoped>
.user-content {
    font-size: 12px;
}
.rule-container p,
.rule-container span {
    text-align: left;
    overflow-wrap: break-word;
    margin: 0;
}
.rule-container span {
    margin-bottom: 1rem;
}
.rule-container p.rule-heading {
    font-size: 14px;
    font-weight: bold;
}
.indent {
    padding-left: 2em;
}
.table {
    border: 1px solid #eee;
}
.table td {
    font-size: 10px;
}
</style>
