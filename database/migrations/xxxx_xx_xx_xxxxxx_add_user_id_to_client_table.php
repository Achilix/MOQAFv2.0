use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToClientTable extends Migration
{
    public function up()
    {
        Schema::table('client', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            // If you want a foreign key constraint:
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('client', function (Blueprint $table) {
            // $table->dropForeign(['user_id']); // Uncomment if you added a foreign key
            $table->dropColumn('user_id');
        });
    }
}
