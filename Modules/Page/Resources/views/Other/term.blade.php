@extends('page::layouts.home')
@section('content')
    <div class="banner-page">
        <div class="box-content-banner-index">
            <h1>利用規約・特定商取引法に基づく表記</h1>
        </div>
        <img class="img-fluid" src="{{ asset('static/images/banner_term.png') }}"/>
    </div>

    <div id="term-content" class="page-content">
        <div class="container container-page">
            <div class="title title-page">
                <span>利用規約</span>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="content">

                        <p>
                            Điều khoản sử dụng này (sau đây gọi là "Điều khoản") sẽ áp dụng cho các dịch vụ (sau đây gọi là "Dịch vụ") do Công ty TNHH REGENESIS (sau đây gọi là "Công ty") cung cấp trên hệ thống này . ) xác định các điều khoản sử dụng. Tất cả người dùng đã đăng ký (sau đây gọi là "người dùng") sẽ sử dụng dịch vụ này theo các Điều khoản này.
                        </p>
                        <h2>Điều 1</h2>
                        <ol class="ak-ol" data-indent-level="1">
                            <li><p data-renderer-start-pos="175">Thỏa thuận này sẽ áp dụng cho tất cả các mối quan hệ liên quan đến việc sử dụng dịch vụ này giữa người dùng và công ty chúng tôi.</p></li>
                            <li>
                                <p data-renderer-start-pos="225">
                                    Về dịch vụ này, ngoài thỏa thuận này, chúng tôi có thể đưa ra các quy định khác nhau như quy tắc sử dụng (sau đây gọi là "quy định riêng"). Bất kể tên của chúng là gì, các điều khoản riêng lẻ này sẽ cấu thành một phần của các Điều khoản này.
                                </p>
                            </li>
                            <li><p data-renderer-start-pos="335">
                                    本規約の規定が前条の個別規定の規定と矛盾する場合には，個別規定において特段の定めなき限り，個別規定の規定が優先されるものとします。</p></li>
                        </ol>
                        <h2>第2条（利用登録）</h2>

                        <ol class="ak-ol" data-indent-level="1">
                            <li><p data-renderer-start-pos="417">
                                    本サービスにおいては，登録希望者が本規約に同意の上，当社の定める方法によって利用登録を申請し，当社がこの承認を登録希望者に通知することによって，利用登録が完了するものとします。</p>
                            </li>
                            <li><p data-renderer-start-pos="509">
                                    当社は，利用登録の申請者に以下の事由があると判断した場合，利用登録の申請を承認しないことがあり，その理由については一切の開示義務を負わないものとします。</p>
                                <ol class="ak-ol" data-indent-level="2">
                                    <li><p data-renderer-start-pos="589">利用登録の申請に際して虚偽の事項を届け出た場合</p></li>
                                    <li><p data-renderer-start-pos="616">本規約に違反したことがある者からの申請である場合</p></li>
                                    <li><p data-renderer-start-pos="644">その他，当社が利用登録を相当でないと判断した場合</p></li>
                                </ol>
                            </li>
                        </ol>

                        <h2>第3条（ユーザーIDおよびパスワードの管理）</h2>

                        <ol class="ak-ol" data-indent-level="1">
                            <li><p data-renderer-start-pos="700">ユーザーは，自己の責任において，本サービスのユーザーIDおよびパスワードを適切に管理するものとします。</p>
                            </li>
                            <li><p data-renderer-start-pos="755">
                                    ユーザーは，いかなる場合にも，ユーザーIDおよびパスワードを第三者に譲渡または貸与し，もしくは第三者と共用することはできません。当社は，ユーザーIDとパスワードの組み合わせが登録情報と一致してログインされた場合には，そのユーザーIDを登録しているユーザー自身による利用とみなします。</p>
                            </li>
                            <li><p data-renderer-start-pos="900">
                                    ユーザーID及びパスワードが第三者によって使用されたことによって生じた損害は，当社に故意又は重大な過失がある場合を除き，当社は一切の責任を負わないものとします。</p>
                            </li>
                        </ol>

                        <h2>第4条（禁止事項）</h2>
                        <p>ユーザーは，本サービスの利用にあたり，以下の行為をしてはなりません。</p>
                        <ol class="ak-ol" data-indent-level="1">
                            <li><p data-renderer-start-pos="1033">法令または公序良俗に違反する行為</p></li>
                            <li><p data-renderer-start-pos="1053">犯罪行為に関連する行為</p></li>
                            <li><p data-renderer-start-pos="1068">
                                    当社，本サービスの他のユーザー，または第三者のサーバーまたはネットワークの機能を破壊したり，妨害したりする行為</p></li>
                            <li><p data-renderer-start-pos="1127">当社のサービスの運営を妨害するおそれのある行為</p></li>
                            <li><p data-renderer-start-pos="1154">他のユーザーに関する個人情報等を収集または蓄積する行為</p></li>
                            <li><p data-renderer-start-pos="1185">不正アクセスをし，またはこれを試みる行為</p></li>
                            <li><p data-renderer-start-pos="1209">他のユーザーに成りすます行為</p></li>
                            <li><p data-renderer-start-pos="1227">当社のサービスに関連して，反社会的勢力に対して直接または間接に利益を供与する行為</p></li>
                            <li><p data-renderer-start-pos="1271">
                                    当社，本サービスの他のユーザーまたは第三者の知的財産権，肖像権，プライバシー，名誉その他の権利または利益を侵害する行為</p></li>
                            <li><p data-renderer-start-pos="1334">以下の表現を含み，または含むと当社が判断する内容を本サービス上に投稿し，または送信する行為</p>
                                <ol class="ak-ol" data-indent-level="2">
                                    <li><p data-renderer-start-pos="1383">過度に暴力的な表現</p></li>
                                    <li><p data-renderer-start-pos="1396">露骨な性的表現</p></li>
                                    <li><p data-renderer-start-pos="1407">人種，国籍，信条，性別，社会的身分，門地等による差別につながる表現</p></li>
                                    <li><p data-renderer-start-pos="1444">自殺，自傷行為，薬物乱用を誘引または助長する表現</p></li>
                                    <li><p data-renderer-start-pos="1472">その他反社会的な内容を含み他人に不快感を与える表現</p></li>
                                </ol>
                            </li>
                            <li><p data-renderer-start-pos="1503">以下を目的とし，または目的とすると当社が判断する行為</p>
                                <ol class="ak-ol" data-indent-level="2">
                                    <li><p data-renderer-start-pos="1533">営業，宣伝，広告，勧誘，その他営利を目的とする行為（当社の認めたものを除きます。）</p>
                                    </li>
                                    <li><p data-renderer-start-pos="1578">性行為やわいせつな行為を目的とする行為</p></li>
                                    <li><p data-renderer-start-pos="1601">面識のない異性との出会いや交際を目的とする行為</p></li>
                                    <li><p data-renderer-start-pos="1628">他のユーザーに対する嫌がらせや誹謗中傷を目的とする行為</p></li>
                                    <li><p data-renderer-start-pos="1659">
                                            当社，本サービスの他のユーザー，または第三者に不利益，損害または不快感を与えることを目的とする行為</p></li>
                                    <li><p data-renderer-start-pos="1712">その他本サービスが予定している利用目的と異なる目的で本サービスを利用する行為</p>
                                    </li>
                                </ol>
                            </li>
                            <li><p data-renderer-start-pos="1756">宗教活動または宗教団体への勧誘行為</p></li>
                            <li><p data-renderer-start-pos="1777">その他，当社が不適切と判断する行為</p></li>
                        </ol>

                        <h2>第5条（本サービスの提供の停止等）</h2>
                        <ol class="ak-ol" data-indent-level="1">
                            <li><p data-renderer-start-pos="1819">
                                    当社は，以下のいずれかの事由があると判断した場合，ユーザーに事前に通知することなく本サービスの全部または一部の提供を停止または中断することができるものとします。</p>
                                <ol class="ak-ol" data-indent-level="2">
                                    <li><p data-renderer-start-pos="1903">本サービスにかかるコンピュータシステムの保守点検または更新を行う場合</p></li>
                                    <li><p data-renderer-start-pos="1941">
                                            地震，落雷，火災，停電または天災などの不可抗力により，本サービスの提供が困難となった場合</p></li>
                                    <li><p data-renderer-start-pos="1989">コンピュータまたは通信回線等が事故により停止した場合</p></li>
                                    <li><p data-renderer-start-pos="2019">その他，当社が本サービスの提供が困難と判断した場合</p></li>
                                </ol>
                            </li>
                            <li><p data-renderer-start-pos="2050">
                                    当社は，本サービスの提供の停止または中断により，ユーザーまたは第三者が被ったいかなる不利益または損害についても，一切の責任を負わないものとします。</p></li>
                        </ol>
                        <h2>第6条（著作権）</h2>

                        <ol class="ak-ol" data-indent-level="1">
                            <li><p data-renderer-start-pos="2139">
                                    ユーザーは，自ら著作権等の必要な知的財産権を有するか，または必要な権利者の許諾を得た文章，画像や映像等の情報に関してのみ，本サービスを利用し，投稿ないしアップロードすることができるものとします。</p>
                            </li>
                            <li><p data-renderer-start-pos="2240">
                                    ユーザーが本サービスを利用して投稿ないしアップロードした文章，画像，映像等の著作権については，当該ユーザーその他既存の権利者に留保されるものとします。ただし，当社は，本サービスを利用して投稿ないしアップロードされた文章，画像，映像等について，本サービスの改良，品質の向上，または不備の是正等ならびに本サービスの周知宣伝等に必要な範囲で利用できるものとし，ユーザーは，この利用に関して，著作者人格権を行使しないものとします。</p>
                            </li>
                            <li><p data-renderer-start-pos="2455">
                                    前項本文の定めるものを除き，本サービスおよび本サービスに関連する一切の情報についての著作権およびその他の知的財産権はすべて当社または当社にその利用を許諾した権利者に帰属し，ユーザーは無断で複製，譲渡，貸与，翻訳，改変，転載，公衆送信（送信可能化を含みます。），伝送，配布，出版，営業使用等をしてはならないものとします。</p>
                            </li>
                        </ol>

                        <h2>第7条（利用制限および登録抹消）</h2>
                        <ol class="ak-ol" data-indent-level="1">
                            <li><p data-renderer-start-pos="2638">
                                    当社は，ユーザーが以下のいずれかに該当する場合には，事前の通知なく，投稿データを削除し，ユーザーに対して本サービスの全部もしくは一部の利用を制限しまたはユーザーとしての登録を抹消することができるものとします。</p>
                                <ol class="ak-ol" data-indent-level="2">
                                    <li><p data-renderer-start-pos="2746">本規約のいずれかの条項に違反した場合</p></li>
                                    <li><p data-renderer-start-pos="2768">登録事項に虚偽の事実があることが判明した場合</p></li>
                                    <li><p data-renderer-start-pos="2794">料金等の支払債務の不履行があった場合</p></li>
                                    <li><p data-renderer-start-pos="2816">当社からの連絡に対し，一定期間返答がない場合</p></li>
                                    <li><p data-renderer-start-pos="2842">本サービスについて，最終の利用から一定期間利用がない場合</p></li>
                                    <li><p data-renderer-start-pos="2874">その他，当社が本サービスの利用を適当でないと判断した場合</p></li>
                                </ol>
                            </li>
                            <li><p data-renderer-start-pos="2908">
                                    前項各号のいずれかに該当した場合，ユーザーは，当然に当社に対する一切の債務について期限の利益を失い，その時点において負担する一切の債務を直ちに一括して弁済しなければなりません。</p>
                            </li>
                            <li><p data-renderer-start-pos="3000">当社は，本条に基づき当社が行った行為によりユーザーに生じた損害について，一切の責任を負いません。</p>
                            </li>
                        </ol>

                        <h2>第8条（退会）</h2>
                        <p>ユーザーは，当社の定める退会手続により，本サービスから退会できるものとします。</p>

                        <h2>第9条（保証の否認および免責事項</h2>


                        <ol class="ak-ol" data-indent-level="1">
                            <li><p data-renderer-start-pos="3123">
                                    当社は，本サービスに事実上または法律上の瑕疵（安全性，信頼性，正確性，完全性，有効性，特定の目的への適合性，セキュリティなどに関する欠陥，エラーやバグ，権利侵害などを含みます。）がないことを明示的にも黙示的にも保証しておりません。</p>
                            </li>
                            <li><p data-renderer-start-pos="3242">
                                    当社は，本サービスに起因してユーザーに生じたあらゆる損害について、当社の故意又は重過失による場合を除き、一切の責任を負いません。ただし，本サービスに関する当社とユーザーとの間の契約（本規約を含みます。）が消費者契約法に定める消費者契約となる場合，この免責規定は適用されません。</p>
                            </li>
                            <li><p data-renderer-start-pos="3384">
                                    前項ただし書に定める場合であっても，当社は，当社の過失（重過失を除きます。）による債務不履行または不法行為によりユーザーに生じた損害のうち特別な事情から生じた損害（当社またはユーザーが損害発生につき予見し，または予見し得た場合を含みます。）について一切の責任を負いません。また，当社の過失（重過失を除きます。）による債務不履行または不法行為によりユーザーに生じた損害の賠償は，ユーザーから当該損害が発生した月に受領した利用料の額を上限とします。</p>
                            </li>
                            <li><p data-renderer-start-pos="3610">
                                    当社は，本サービスに関して，ユーザーと他のユーザーまたは第三者(掲載企業含む)との間において生じた取引，連絡または紛争等について一切責任を負いません。</p></li>
                        </ol>

                        <h2>第10条（サービス内容の変更等）</h2>
                        <p>当社は，ユーザーへの事前の告知をもって、本サービスの内容を変更、追加または廃止することがあり、ユーザーはこれを承諾するものとします。</p>


                        <h2>第11条（利用規約の変更）</h2>
                        <ol class="ak-ol" data-indent-level="1">
                            <li><p data-renderer-start-pos="3792">当社は以下の場合には、ユーザーの個別の同意を要せず、本規約を変更することができるものとします。</p>
                                <ol class="ak-ol" data-indent-level="2">
                                    <li><p data-renderer-start-pos="3843">本規約の変更がユーザーの一般の利益に適合するとき。</p></li>
                                    <li><p data-renderer-start-pos="3872">
                                            本規約の変更が本サービス利用契約の目的に反せず、かつ、変更の必要性、変更後の内容の相当性その他の変更に係る事情に照らして合理的なものであるとき。</p>
                                    </li>
                                </ol>
                            </li>
                            <li><p data-renderer-start-pos="3950">
                                    当社はユーザーに対し、前項による本規約の変更にあたり、事前に、本規約を変更する旨及び変更後の本規約の内容並びにその効力発生時期を通知します。</p></li>
                        </ol>

                        <h2>第12条（個人情報の取扱い）</h2>
                        <p>当社は，本サービスの利用によって取得する個人情報については，当社「プライバシーポリシー」に従い適切に取り扱うものとします。</p>


                        <h2>第13条（通知または連絡）</h2>
                        <p>
                            ユーザーと当社との間の通知または連絡は，当社の定める方法によって行うものとします。当社は,ユーザーから,当社が別途定める方式に従った変更届け出がない限り,現在登録されている連絡先が有効なものとみなして当該連絡先へ通知または連絡を行い,これらは,発信時にユーザーへ到達したものとみなします。</p>


                        <h2>第14条（権利義務の譲渡の禁止）</h2>
                        <p>ユーザーは，当社の書面による事前の承諾なく，利用契約上の地位または本規約に基づく権利もしくは義務を第三者に譲渡し，または担保に供することはできません。</p>

                        <h2>第15条（準拠法・裁判管轄）</h2>
                        <ol class="ak-ol" data-indent-level="1">
                            <li><p data-renderer-start-pos="4377">本規約の解釈にあたっては，日本法を準拠法とします。</p></li>
                            <li><p data-renderer-start-pos="4406">本サービスに関して紛争が生じた場合には，当社の本店所在地を管轄する裁判所を専属的合意管轄とします。</p>
                            </li>
                        </ol>


                    </div>
                </div>
            </div>

            <div class="title title-page mt-5">
                <span>特定商取引法に基づく表記</span>
            </div>

            <div class="container">

                <div class="row">
                    <div class="col-md-11" style="margin: 0 auto">
                        <div class="content table-content table-company mb-0 font-18">

                            <table class="table table-striped mb-0">
                                <tr>
                                    <td>販売事業者名</td>
                                    <td><p class="font-bold">株式会社REGENESIS</p></td>
                                </tr>

                                <tr>
                                    <td>運營統括責任者</td>
                                    <td><p class="font-bold">代表取締役 花井直哉</p></td>
                                </tr>

                                <tr>
                                    <td>所在地</td>
                                    <td><p class="font-bold">1400014 東京都品川区大井1丁目6番3号アゴラ大井町3階</p></td>
                                </tr>
                                <tr>
                                    <td>メールアドレス</td>
                                    <td><p class="font-bold">naoyahanai@regenesis.biz</p></td>
                                </tr>
                                <tr>
                                    <td>お問い合わせ</td>
                                    <td><p class="font-bold">https://s-gantt.com/contact</p></td>
                                </tr>

                                <tr>
                                    <td>電話番号</td>
                                    <td><p class="font-bold">080-4543-6640</p></td>
                                </tr>

                                <tr>
                                    <td>コーポレートサイト</td>
                                    <td><p class="font-bold">https ://regenesis.biz/</p></td>
                                </tr>
                                <tr>
                                    <td>お支払い方法</td>
                                    <td><p class="font-bold">クレジットカード</p></td>
                                </tr>

                                <tr>
                                    <td>決済期間</td>
                                    <td><p class="font-bold">有料プラン申し込み時、プラン更新は毎月1日</p></td>
                                </tr>
                                <tr>
                                    <td>配達時間</td>
                                    <td><p class="font-bold">サービスの性質上、配達に関する事項はありません</p></td>
                                </tr>

                                <tr>
                                    <td>商品代金以外の必要料金</td>
                                    <td><p class="font-bold">消費稅</p></td>
                                </tr>

                                <tr>
                                    <td>お支払い金額</td>
                                    <td><p class="font-bold">お支払い金額につきましては 「料金ページ」をご確認ください。</p></td>
                                </tr>
                                <tr>
                                    <td>返金について</td>
                                    <td><p class="font-bold">サービスの性質上、一切の返金を受け付けておりません。</p></td>
                                </tr>


                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
